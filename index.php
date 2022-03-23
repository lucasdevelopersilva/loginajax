<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

	<title>Login com ajax</title>

	<meta name="keywords" content="login, ajax, php, sql" />
	<meta name="description" content="Realizando login com ajax">
	<meta name="author" content=""> 
	<!-- Main CSS File --> 
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body class="">
	<div class="card mx-auto mt-5 p-5 col-sm-4">
		<div class="h4 text-center">Faça seu login</div>
		<div class="message"></div>
		<form class='card-login'>
			<div class="form-group p-2">
				<input name="email" class="form-control" placeholder="Seu e-mail">
			</div>
			<div class="form-group p-2">
				<input name="pass" class="form-control" placeholder="Sua senha">
			</div>
			<div class="form-group p-2">
				<button class='btn btn-primary  w-100 js-entrar' data-action='login_user'>ENTRAR</button>
				<hr>
				<button class='btn btn-primary  w-100 js-cadastrar' data-action='create_user'>CADATRE-SE</button>
			</div>
		</form>

	</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
	$(function(){
		$.ajaxSetup({type:"POST","dataType":"jSon","beforeSend":function(){
			$('.message').html(alertBoostrap('realizando login...',"info"));
		},error:function(response){
			$('.message').html(alertBoostrap('Houve um erro interno no processamento das informações. Tente mais tarde.',"danger"));
		}});

		var alertBoostrap = function(content, type){
			return "<div class='alert alert-"+type+"'>"+content+"</div>";
		};


		var sendform = function(){
			var action = $(this).data('action');			

			var email = $('[name="email"]').val();
			var pass = $('[name="pass"]').val();
			if(!email && !pass){
				$('.message').html(alertBoostrap('Oxe! Sem informa o e-mail e senha não podemos continuar.',"warning"));
				return false;
			}


			var success = function(response){
				$('.message').html(alertBoostrap(response.message[0],response.message[1]));

				if(response.success){
					window.location.href = response.redirect;
				} 
			}



			$.ajax({url:"callback/login.php",data:$('form').serialize()+"&action="+action,success:success});

			return false;

		}

		$('.js-entrar').on('click',sendform);
		$('.js-cadastrar').on('click',sendform);
	});
</script>


</html>