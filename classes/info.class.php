<?php

class info extends DB{

    public function loginSessionComun($user, $pass){
	$sql = "SELECT * FROM tb_usuarios_comun WHERE nickname_usuario_comun = '{$user}' AND password_usuario = '{$pass}'";
        $row = $this->row($sql);
        return $row;
	//return $row['COUNT(*)'];
    }
    public function loginSessionAdmin($user, $pass){
	$sql = "SELECT * FROM tb_usuarios WHERE nickname_usuario = '{$user}' AND pass_usuario = '{$pass}'";
        $row = $this->row($sql);
        return $row;
	//return $row['COUNT(*)'];
    }
    public function consulPaises() {
        $sql = "SELECT CountryId, Country FROM tb_paises ORDER BY Country ASC";
        $row = $this->result($sql);
        return $row;
    }
    public function consulCiudades($pais) {
        $sql = "SELECT CityId, City FROM tb_ciudad WHERE CountryId = '{$pais}' ORDER BY City ASC";
        $row = $this->result($sql);
        return $row;
    }
    public function consulRegiones($pais) {
        $sql = "SELECT RegionId, Region FROM tb_region WHERE CountryId = '{$pais}' ORDER BY Region ASC";
        $row = $this->result($sql);
        return $row;
    }
    public function updatePerfil($datos, $id) {
        $sql = "UPDATE tb_usuarios_comun SET nombre_usuario_comun = '{$datos->nombre}', apellido_usuario_comun = '{$datos->apellido}', tel1_usuario_comun = {$datos->telefono}, tel2_usuario_comun = {$datos->cell}, pais_usuario_comun = {$datos->pais}, ciudad_usuario_comun = '{$datos->ciudad}', region_usuario_comun = {$datos->region}, direccion_usuario_comun = '{$datos->direccion}', email_usuario_comun = '{$datos->mail}'  WHERE id_usuarios_comun = '{$id}'";
        $row = $this->update($sql);
        return $row;
    }
    public function consulPerfil($id){
        $sql = "SELECT tb_usuarios_comun.nickname_usuario_comun, tb_usuarios_comun.password_usuario, tb_usuarios_comun.nombre_usuario_comun, tb_usuarios_comun.apellido_usuario_comun, tb_usuarios_comun.email_usuario_comun, tb_usuarios_comun.tel1_usuario_comun, tb_usuarios_comun.tel2_usuario_comun, tb_usuarios_comun.direccion_usuario_comun, tb_paises.Country, tb_usuarios_comun.ciudad_usuario_comun, tb_paises.CountryId, tb_region.RegionId, tb_region.Region FROM tb_usuarios_comun INNER JOIN tb_paises ON tb_usuarios_comun.pais_usuario_comun = tb_paises.CountryId INNER JOIN tb_region ON tb_usuarios_comun.region_usuario_comun = tb_region.RegionId WHERE tb_usuarios_comun.id_usuarios_comun = '{$id}'";
      //$sql = "SELECT tb_usuarios_comun.nickname_usuario_comun, tb_usuarios_comun.password_usuario, tb_usuarios_comun.nombre_usuario_comun, tb_usuarios_comun.apellido_usuario_comun, tb_usuarios_comun.email_usuario_comun, tb_usuarios_comun.tel1_usuario_comun, tb_usuarios_comun.tel2_usuario_comun, tb_usuarios_comun.direccion_usuario_comun, tb_paises.Country, tb_ciudad.City, tb_paises.CountryId, tb_ciudad.CityId FROM tb_usuarios_comun INNER JOIN tb_paises ON tb_usuarios_comun.pais_usuario_comun = tb_paises.CountryId INNER JOIN tb_ciudad ON tb_usuarios_comun.ciudad_usuario_comun = tb_ciudad.CityId WHERE tb_usuarios_comun.id_usuarios_comun = '{$id}'";
        $row = $this->row($sql);
        return $row;
	//return $row['COUNT(*)'];
    }
    public function consultaUserMail($nick, $mail){
        $sql1 = "SELECT * FROM tb_usuarios_comun WHERE nickname_usuario_comun = '{$nick}'";
        $sql2 = "SELECT * FROM tb_usuarios_comun WHERE email_usuario_comun = '{$mail}'";
        $row[0] = $this->result($sql1);
        $row[1] = $this->row($sql2);
        return $row;
    }
    public function nuevoUserComun($datos){
        $sql = "INSERT INTO tb_usuarios_comun (nickname_usuario_comun, password_usuario, tipo_role, nombre_usuario_comun, apellido_usuario_comun, tel1_usuario_comun, tel2_usuario_comun, pais_usuario_comun, ciudad_usuario_comun, region_usuario_comun, direccion_usuario_comun, email_usuario_comun, usuario_comun_activo, contacto_usuario_comun) VALUES ('{$datos->nick}','{$datos->pass}',4,'{$datos->nombre}','{$datos->apellido}',{$datos->tel},{$datos->cell},{$datos->pais},'{$datos->ciudad}',{$datos->region},'{$datos->direccion}','{$datos->mail}',1,1)";
        $insert = $this->insert($sql);
        return $insert;
    }
    
    public function consu(){
        $sql = "SELECT id_producto FROM tb_productos ORDER BY id_producto DESC";
        $row = $this->row($sql);
        return $row;
    }
    
    public function insertProducto($nombre,$valor,$imagenes,$cantidad,$descripcion){
        $sql = "INSERT INTO tb_productos (nombre_producto, valor_producto, categoria_producto, imagen1_producto, cantidad_producto, descripcion_producto, fecha_ingreso_producto, disponible_producto) VALUES ('".$nombre."',".$valor.",'1','".$imagenes."',".$cantidad.",'".$descripcion."','".date('d/m/y')."',1)";
        $insert = $this->insert($sql);
        return $insert;
    }
    
    public function productosAdminConsul(){
        $sql = "SELECT id_producto, nombre_producto, valor_producto, cantidad_producto, disponible_producto, descripcion_producto FROM tb_productos ORDER BY nombre_producto ASC";
        $row = $this->result($sql);
        return $row;
    }
    
    public function clientesAdminConsul(){
        $sql = "SELECT tb_usuarios_comun.nickname_usuario_comun, tb_usuarios_comun.password_usuario, tb_usuarios_comun.nombre_usuario_comun, tb_usuarios_comun.apellido_usuario_comun, tb_usuarios_comun.email_usuario_comun, tb_usuarios_comun.tel1_usuario_comun, tb_usuarios_comun.tel2_usuario_comun, tb_usuarios_comun.direccion_usuario_comun, tb_paises.Country, tb_usuarios_comun.ciudad_usuario_comun, tb_paises.CountryId, tb_region.RegionId, tb_region.Region, tb_usuarios_comun.usuario_comun_activo, tb_usuarios_comun.contacto_usuario_comun  FROM tb_usuarios_comun INNER JOIN tb_paises ON tb_usuarios_comun.pais_usuario_comun = tb_paises.CountryId INNER JOIN tb_region ON tb_usuarios_comun.region_usuario_comun = tb_region.RegionId";
        $row = $this->result($sql);
        return $row;
    }
    
    public function empleadosAdminConsul(){
        $sql = "SELECT tb_usuarios.nombre_usuario, tb_usuarios.apellido_usuario, tb_usuarios.email_usuarios, tb_paises.Country, tb_usuarios.ciudad_usuario, tb_roles.nombre_role FROM tb_usuarios INNER JOIN tb_roles ON tb_usuarios.role_usuarios = tb_roles.id_role INNER JOIN tb_paises ON tb_usuarios.pais_usuario = tb_paises.CountryId";
        $row = $this->result($sql);
        return $row;
    }
}
$info = new info;
