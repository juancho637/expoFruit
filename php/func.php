<?php

include_once '../includes/config.php';
include_once '../classes/DB.class.php';
include_once '../classes/info.class.php';
$data = file_get_contents('php://input');
$json = json_decode($data);
$GLOBALS['json'] = $json;
$type = $json->type;
switch($type){
	case 'login':
	aLogin();
	break;
	
	case 'loginConsult':
	aLoginConsult();
	break;
	
	case 'addNewC':
	aAddNewC();
	break;
	
	case 'listMod':
	aListMod();
	break;
	
	case 'delList':
	aDelList();
	break;
	
	case 'callMod':
	aCallMod();
	break;
	
	case 'prevList':
	aPrevList();
	break;
	
	case 'modNewC':
	aModNewC();
	break;
	
	case 'cerrarSession':
	aCerrarSession();
	break;

	case 'inserUser':
	inserUserr();
	break;
}

function inserUserr(){
	$json = $GLOBALS['json'];
	session_start();
	$pass = md5($json->pass);
	echo("<script> alert(".$json."); </script>");
}

function aLogin(){
	$json = $GLOBALS['json'];
	session_start();
	$pass = $json->pass;//md5($json->pass);
	$count = $GLOBALS['info']->loginSession($json->user, $pass);
	$_SESSION['username'] = $json->user;
	$_SESSION['password'] = $pass;
	echo $count;
}

function aLoginConsult(){
	$json = $GLOBALS['json'];
	session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$user = $_SESSION['username'];
		$pass = $_SESSION['password'];
		$count = $GLOBALS['info']->loginSession($user, $pass);
		echo $count;
	}else{
		echo 0;
	}
}

function aAddNewC(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$GLOBALS['info']->addNew($json, $per_id);
}

function aListMod(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$rsl = $GLOBALS['info']->listMod($per_id);
	echo json_encode($rsl);
}

function aDelList(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$GLOBALS['info']->EliminarModulo($per_id, $json->mod_id);
}

function aCallMod(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$rsl = $GLOBALS['info']->LlamarListaParaModificar($per_id, $json->mod_id);
	$rsl2 = $GLOBALS['info']->llamarLista2($json->mod_id);
	echo json_encode(array("data" => $rsl, "data2" => $rsl2));
}

function aPrevList(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$rsl = $GLOBALS['info']->LlamarListaParaModificar($per_id, $json->mod_id);
	$rsl2 = $GLOBALS['info']->llamarLista2($json->mod_id);
	echo json_encode(array("data" => $rsl, "data2" => $rsl2));
}

function aModNewC(){
	$json = $GLOBALS['json'];
	session_start();
	$user = $_SESSION['username'];
	$per_id = $GLOBALS['info']->persona($user);
	$GLOBALS['info']->ModificarModulo($per_id, $json);
}

function aCerrarSession(){
	session_start();
	$_SESSION['username'] = "";
	$_SESSION['password'] = "";
	session_destroy();
}