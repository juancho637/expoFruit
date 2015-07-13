<?php
    include_once '../includes/config.php';
    include_once '../classes/DB.class.php';
    include_once '../classes/info.class.php';
    
    $consul = $GLOBALS['info']->consu();
    
    $idd = $consul[0]['id_producto']+1;
    
    $nombre = $_POST['nombreProducto'];
    $file1 = $_FILES['file1']["tmp_name"];
    $file2 = $_FILES['file2']["tmp_name"];
    $file3 = $_FILES['file3']["tmp_name"];
    $descripcion = $_POST['descropcion'];
    $valor = $_POST['valor'];
    $cantidad = $_POST['cantidad'];
    $pila = array();
    $imagenes = '';
    
    
    if ($file1 != ''){
        array_push($pila, array("nombre"=>$_FILES['file1']["name"],"lugar"=>$_FILES['file1']["tmp_name"]));
    }
    if ($file2 != ''){
        array_push($pila, array("nombre"=>$_FILES['file2']["name"],"lugar"=>$_FILES['file2']["tmp_name"]));
    }
    if ($file3 != ''){
        array_push($pila, array("nombre"=>$_FILES['file3']["name"],"lugar"=>$_FILES['file3']["tmp_name"]));
    }
    for ($i = 0;$i < count($pila);$i++){
        $arNombre = $idd.$nombre."__".$pila[$i]['nombre'];
        if ($i == 0){
            $imagenes .= $arNombre;
        }
        if($i != 0){
            $imagenes .= ",".$arNombre;
        }
        move_uploaded_file($pila[$i]['lugar'], "../imagenes/productos/".$arNombre);
    }
    
    $inser = $GLOBALS['info']->insertProducto($nombre,$valor,$imagenes,$cantidad,$descripcion);
    
    header('Location: ../#/proctosAdmin');