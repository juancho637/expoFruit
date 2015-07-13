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
    
        case 'nuevo':
            nuevo();
        break;

        case 'loginConsult':
            aLoginConsult();
        break;
    
        case 'updatePerfil':
            updatePerfil();
        break;

        case 'cerrarSession':
            aCerrarSession();
        break;
    
        case 'consultaPerfil':
            consultaPerfil();
        break;
    
        case 'consultaPais':
            consultaPais();
        break;
    
        case 'consultaRegion':
            consultaRegion();
        break;
        
        case 'consultaCiudades':
            consultaCiudades();
        break;
    
        case 'consultaUserMail':
            consultaUserMail();
        break;
    
        case 'datosProfuctos':
            datosProfuctos();
        break;
    
        case 'productosAdminConsul':
            productosAdminConsul();
        break;
    
        case 'clientesAdminConsul':
            clientesAdminConsul();
        break;
    }
    
    function aLogin(){//se ejecuta cuando alguien le da a el boton inciar sesión
	$json = $GLOBALS['json'];
        session_start();
	$pass = $json->pass;//md5($json->pass);
	$count = $GLOBALS['info']->loginSessionComun($json->user, $pass);
	$_SESSION['username'] = $json->user;
	$_SESSION['password'] = $pass;
        $_SESSION['id'] = $count[0][0];
        if(json_encode($count) == "null"){// si no se encuentra ningun dato como usuario comun revisa el usuario de administración
            $count2 = $GLOBALS['info']->loginSessionAdmin($json->user, $pass);
            echo json_encode($count2);
        }else{
            echo json_encode($count);
        }
    }

    function aLoginConsult(){//se ejecuta al iniciar la pagina para saber si alguien esta logueado
	$json = $GLOBALS['json'];
	session_start();
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
            $user = $_SESSION['username'];
            $pass = $_SESSION['password'];
            $count = $GLOBALS['info']->loginSessionComun($user, $pass);
            if(json_encode($count) == "null"){// si no se encuentra ningun dato como usuario comun revisa el usuario de administración
                $count2 = $GLOBALS['info']->loginSessionAdmin($user, $pass);
                echo json_encode($count2);
            }else{
                echo json_encode($count);
            }
	}else{
            echo 'null';
	}
    }
    
    function consultaPerfil(){
        session_start();
        $id = $_SESSION['id'];
        $consul = $GLOBALS['info']->consulPerfil($id);
        $paises = $GLOBALS['info']->consulPaises();
        $regiones = $GLOBALS['info']->consulRegiones($consul[0][10]);
        $consul[0]["selecP"] = ["CountryId"=>$consul[0][10], "Country"=>$consul[0][8]];
        $consul[0]["selecR"] = ["RegionId"=>$consul[0][11], "Region"=>$consul[0][12]];
        $pais = ["paises"=>$paises];
        $region = ["regiones"=>$regiones];
        $union = array_merge($consul, $pais, $region);
        echo json_encode($union);
    }
    
    function updatePerfil(){
        session_start();
        $id = $_SESSION['id'];
        $json = $GLOBALS['json'];
        $update = $GLOBALS['info']->updatePerfil($json,$id);
        echo $update;
    }

    function consultaPais(){
        $paises = $GLOBALS['info']->consulPaises();
        echo json_encode($paises);
    }
    
    function consultaRegion(){
        $json = $GLOBALS['json'];
        $Regiones = $GLOBALS['info']->consulRegiones($json->valor);
        echo json_encode($Regiones);
    }
    
    function consultaCiudades(){
        $json = $GLOBALS['json'];
        $ciudades = $GLOBALS['info']->consulRegiones($json->valor);
        $valor["selecR"] =["RegionId"=>"", "Region"=>""];
        $ciudad = ["regiones"=>$ciudades];
        $consul = array_merge($valor,$ciudad);
        //var_dump($ciudades);
        echo json_encode($consul);
    }

    function aCerrarSession(){//se ejecuta cuando alguien le da a el boton cerra sesión
	session_start();
	$_SESSION['username'] = "";
	$_SESSION['password'] = "";
	session_destroy();
    }
    
    function consultaUserMail(){
        $json = $GLOBALS['json'];
        $count = $GLOBALS['info']->consultaUserMail($json->nickName, $json->mail);
        $union = [count($count[0]),count($count[1])];
        echo json_encode($union);
    }
    
    function datosProfuctos(){
        $json = $GLOBALS['json'];
        $file = $_FILES['file1']['type'];
        var_dump($file);
    }

    function nuevo(){
        $json = $GLOBALS['json'];
        $count = $GLOBALS['info']->nuevoUserComun($json);
        echo $count;
    }
    
    function productosAdminConsul(){
        $count = $GLOBALS['info']->productosAdminConsul();
        echo json_encode($count);
    }
    
    function clientesAdminConsul(){
        $count = $GLOBALS['info']->clientesAdminConsul();
        echo json_encode($count);
    }