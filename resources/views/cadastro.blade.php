<html ng-app="CadastroApp">
	<head>
		<title>Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</title>

		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min.js"></script>

		<script src="bower_components/jQuery-Mask-Plugin/dist/jquery.mask.js"></script>

		<script src="CadastroApp/components/input-mask/input-mask.js"></script>
		<script src="CadastroApp/app.js"></script>

		<script>
        	angular.module("CadastroApp").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
    	</script>

		<script src="CadastroApp/cadastro/cadastro.js"></script>
		<style>

		</style>
	</head>
	<body ng-controller="CadastroController">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ficha Cadastral e Termo de Adesão ao Serviço Voluntário</h3>
				</div>
				<div class="panel-body">
					<form name="CadastroForm" method="POST"
						ng-submit="CadastroForm.$valid && submitForm()" fields="fields" data="trabalhador"
						class="form-horizontal" novalidate>
					</form>
				</div>
		</div>
	</body>
</html>
