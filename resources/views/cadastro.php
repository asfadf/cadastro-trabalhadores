<html ng-app="CadastroApp">
	<head>
		<title>Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	</head>
	<body ng-controller="CadastroController">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</h3>
				</div>
				<div class="panel-body">

					<div class="text-center">
						<img src="/images/loading.gif" ng-show="!showForm">
					</div>

					<form ng-show="showForm" name="CadastroForm" method="POST"
					ng-submit="CadastroForm.$valid && submitForm()" class="form-horizontal" novalidate>
				        <input-bootstrap field-data="field" ng-repeat="key in notSorted(fields)" ng-init="field = fields[key]"
				        ng-model="trabalhador[field.external_id]"></input-bootstrap>

						<div ng-if="CadastroForm.$submitted && !CadastroForm.$valid" class="alert alert-danger">
						    <strong>Ops, existem dados não preenchidos ou com dados inválidos.</strong> Por favor verifique todos os campos em vermelho acima.
						</div>

						<button type="submit" class="btn btn-primary">Enviar formulário</button>
					</form>
				</div>
			</div>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min.js"></script>

		<script src="bower_components/jQuery-Mask-Plugin/dist/jquery.mask.js"></script>

		<script src="CadastroApp/components/input-mask/input-mask.js"></script>
		<script src="CadastroApp/components/input-bootstrap/input-bootstrap.js"></script>
		<script src="CadastroApp/app.js"></script>

		<script>
        	angular.module("CadastroApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
    	</script>

		<script src="CadastroApp/cadastro/cadastro.js"></script>
	</body>
</html>
