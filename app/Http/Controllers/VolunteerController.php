<?php namespace App\Http\Controllers;

use Input;
use Session;
use View;
use Response;
use PDF;

class VolunteerController extends Controller {

	private $client_id = 'voluntarios';
	private $client_secret = 'yOOUSYUrAe8unTIYP6TtBDnuTkVIwt7DVpWtdKeE3QFIyd6e8fjiHQC5MVuZtt7M';
	private $app_id = '5125154';
	private $app_token = '458d8e2cd53742748bb252c49f7d0c33';

	public function __construct()
	{
		$this->middleware('guest');

		// Connect in PODIO API
		\Podio::setup($this->client_id, $this->client_secret);
		\Podio::authenticate_with_app($this->app_id, $this->app_token);
	}

	public function index()
	{
		return view('cadastro');
	}

	public function getVolunteerFields()
	{
		$app = \PodioApp::get($this->app_id);
		$fields = $app->fields;

		$fieldsLength = count($fields);

		$fieldsArray = [];
		for ($i = 0; $i < $fieldsLength; $i++) {
			// Se o campo não estiver ativo, ignora
			if ($fields[$i]->status !== 'active' || $fields[$i]->config['hidden'] === true) {
				continue;
			}

			$externalId = $fields[$i]->external_id;
			$type = $fields[$i]->type;
			$settings = $fields[$i]->config['settings'];

			// Retira as options deleted
			if (isset($settings['options'])) {
				$optionsLength = count($settings['options']);
				for ($j = 0; $j < $optionsLength; $j++) {
					if ($settings['options'][$j]['status'] !== 'active') {
						unset($settings['options'][$j]);
					}
				}
			}

			$fieldsArray[$i] = [];
			$fieldsArray[$i]['field_id'] = $fields[$i]->field_id;
			$fieldsArray[$i]['external_id'] = $externalId;
			$fieldsArray[$i]['type'] = $type;
			$fieldsArray[$i]['description'] = $fields[$i]->config['description'];
			$fieldsArray[$i]['label'] = $fields[$i]->config['label'];
			$fieldsArray[$i]['required'] = $fields[$i]->config['required'];
			$fieldsArray[$i]['delta'] = $fields[$i]->config['delta'];
			$fieldsArray[$i]['settings'] = $settings;

			// Seta a máscara do input
			$mask = '';
			if ($externalId === 'cpf') {
				$mask = '999.999.999-99';
			} else if ($externalId === 'cep') {
				$mask = '99999-999';
			} else if (strpos($externalId, 'telefone') !== FALSE || $externalId === 'celular') {
				$mask = '(99) 9999-99999';
			} else if ($type === 'date') {
				$mask = '99/99/9999';
			}

			// Seta o placeholder de acordo com a máscara
			$placeholder = '';
			if ($mask) {
				$placeholder = str_replace('9', '_', $mask);
			}

			// Se for email faz tratamento especial
			if (strpos($externalId, 'email') !== FALSE || strpos($externalId, 'e-mail') !== FALSE) {
				$fieldsArray[$i]['type'] = 'email';
			}

			$fieldsArray[$i]['placeholder'] = $placeholder;

			$fieldsArray[$i]['mask'] = $mask;
		}

		Session::put('fields', $fieldsArray);

		return $fieldsArray;
	}

	public function addVolunteer()
	{
		$data = Input::all();
		Session::put('volunteer', $data);

		try {
			return \PodioItem::create($this->app_id, array('fields' => $data));
		} catch(\PodioBadRequestError $e) {
			return Response::make($e, 500);
		}

	}

	public function generatePDF() {
		$volunteer = Session::get('volunteer');
		$fields = Session::get('fields');

		$view = View::make('generate-pdf')->with('volunteer', $volunteer)->with('fields', $fields);

		// dd($fields);
		// dd($volunteer);

		return $view = $view->render();
		$view = str_replace("\n", '', $view);

	    $pdf = PDF::make();
	    $pdf->addPage($view);
	    $pdf->send();
	}

}
