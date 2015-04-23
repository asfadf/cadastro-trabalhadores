<?php namespace App\Http\Controllers;

class CadastroController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Mostra a tela de cadastro do trabalhador
	 *
	 * @return Response
	 */
	public function index()
	{
		// $client_id = 'voluntarios';
		// $client_secret = 'yOOUSYUrAe8unTIYP6TtBDnuTkVIwt7DVpWtdKeE3QFIyd6e8fjiHQC5MVuZtt7M';
		// $app_id = '5125154';
		// $app_token = '458d8e2cd53742748bb252c49f7d0c33';

		// $podio = new \Podio();
		// // $podioItem = new \PodioItem();
		// $podioForm = new \PodioForm();
		// $podioApp = new \PodioApp();

		// $podio::setup($client_id, $client_secret);
		// $podio::authenticate_with_app($app_id, $app_token);

		// $app = $podioApp->get($app_id);
		// $fields = $app->fields;
		// dd($fields);

		// $fieldsLength = count($fields);

		// $fieldsArray = [];
		// for ($i = 0; $i < $fieldsLength; $i++) {
		// 	// Se o campo não estiver ativo, ignora
		// 	if ($fields[$i]->status != 'active') {
		// 		continue;
		// 	}

		// 	$fieldsArray[$i] = [];
		// 	$fieldsArray[$i]['field_id'] = $fields[$i]->field_id;
		// 	$fieldsArray[$i]['external_id'] = $fields[$i]->external_id;
		// 	$fieldsArray[$i]['type'] = $fields[$i]->type;
		// 	$fieldsArray[$i]['label'] = $fields[$i]->config['label'];
		// 	$fieldsArray[$i]['required'] = $fields[$i]->config['required'];
		// 	$fieldsArray[$i]['settings'] = $fields[$i]->config['settings'];
		// }
		// dd($fieldsArray);


		// return $fieldsArray;

		return view('cadastro');
	}

	public function getFormFields()
	{
		$client_id = 'voluntarios';
		$client_secret = 'yOOUSYUrAe8unTIYP6TtBDnuTkVIwt7DVpWtdKeE3QFIyd6e8fjiHQC5MVuZtt7M';
		$app_id = '5125154';
		$app_token = '458d8e2cd53742748bb252c49f7d0c33';

		$podio = new \Podio();
		// $podioItem = new \PodioItem();
		$podioForm = new \PodioForm();
		$podioApp = new \PodioApp();

		$podio::setup($client_id, $client_secret);
		$podio::authenticate_with_app($app_id, $app_token);

		$app = $podioApp->get($app_id);
		$fields = $app->fields;

		$fieldsLength = count($fields);

		$fieldsArray = [];
		for ($i = 0; $i < $fieldsLength; $i++) {
			// Se o campo não estiver ativo, ignora
			if ($fields[$i]->status !== 'active') {
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
			$fieldsArray[$i]['settings'] = $settings;

			// Seta a máscara do input
			$mask = '';
			if ($externalId === 'cpf') {
				$mask = '000.000.000-00';
			} else if ($externalId === 'cep') {
				$mask = '00000-000';
			} else if (strpos($externalId, 'telefone') !== FALSE || $externalId === 'celular') {
				$mask = '(00) 0000-00000';
			} else if ($type === 'date') {
				$mask = '00/00/0000';
			}

			// Seta o placeholder de acordo com a máscara
			$placeholder = '';
			if ($mask) {
				$placeholder = str_replace('0', '_', $mask);
			}

			// Se for email faz tratamento especial
			if (strpos($externalId, 'email') !== FALSE || strpos($externalId, 'e-mail') !== FALSE) {
				$fieldsArray[$i]['type'] = 'email';
			}

			$fieldsArray[$i]['placeholder'] = $placeholder;

			$fieldsArray[$i]['mask'] = $mask;
		}

		return $fieldsArray;
	}

}
