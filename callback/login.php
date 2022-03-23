<?php 

require "../_app/Config.inc.php";

$POST = filter_input_array(INPUT_POST,FILTER_DEFAULT);

$action = false;
$json = [];
$json['success'] = false;
$json['error'] = false;

if(!empty($POST['action'])){
	$action = $POST['action'];
	unset($POST['action']);
}

switch($action):
	case "create_user":

	$Create = new Create();
	$Create->ExeCreate("ph_users",$POST);
	if($Create->getResult()):
		$json['success'] = true;
		$json['message'] = ["Cadastro concluído",'success'];
	else:
		$json['error'] = true;
		$json['message'] = ["Falha na realização de seu cadastro",'warning'];
	endif;
	break;

	case "login_user":

	$Read = new Read();
	$Read->ExeRead("ph_users","WHERE email=:em AND pass=:pass","em={$POST['email']}&pass={$POST['pass']}");
	if($Read->getResult()):
		$json['success'] = true;
		$json['message'] = ["Login realizado",'success'];
		$json['redirect'] ="https://google.com";
	else:
		$json['error'] = true;
		$json['message'] = ["Cadastro não encontrado",'warning'];
	endif;
	break;
	default:

 
		$json['error'] = true;
		$json['message'] = ["Comamdo não autorizado pelo sistema",'warning'];
 
	break;
endswitch;


echo json_encode($json);
