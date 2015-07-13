<?php

abstract class Modelo {
    private static $db_host = ""; 
    private static $db_user = "root";
    private static $db_pass = "root";
    protected $db_name = "";
    protected $sql;
    protected $rows = array();
    protected $last_id;
    private $conexion;
    
    abstract protected function consultar();
    abstract protected function nuevo();
    abstract protected function editar();
    abstract protected function borrar();
    abstract protected function lista();
    
    private function abrirConexion(){
        $this->conexion = new mysqli(self::$db_host,  self::$db_user, self::$db_pass, $this->db_name);
    }
    
    private function cerrarConexion(){
        $this->conexion->close();
    }
    
    protected function ejecutarQuery(){
        $this->abrirConexion();
        $this->conexion->query($this->sql) or die(json_encode(array('error' => 'Se ha producido el error: '.mysqli_errno($this->conexion)." : ".  mysqli_error($this->conexion)/*." | Query = ".$this->sql*/)));
        $this->last_id = $this->conexion->insert_id;
        $this->cerrarConexion();
    }
    
    protected function obtenerResultado(){
        $this->abrirConexion();
        $result = $this->conexion->query($this->sql) or die(json_encode(array('error'=>mysqli_errno($this->conexion)." : ".  mysqli_error($this->conexion."  | Query = ".$this->sql))));
        $this->rows = array();
        while ($this->rows[] = $result->fetch_assoc());
        $result->close();
        $this->cerrarConexion();
        array_pop($this->rows);
    }
}
?>