<?php

require_once("interface/IEntity.php");

class Usuario implements IEntity {
    public $nombre;
    public $clave;
    public $tipoUsuarioId;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct3($nombre, $clave, $tipo_usuario) {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->tipoUsuarioId = $this->obtenerIdTipoUsuarioPorNombre($tipo_usuario);
    }    

    public function obtenerIdTipoUsuarioPorNombre($nombre) {
        $accesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $accesoDatos->prepararConsulta("SELECT id FROM TipoUsuario WHERE tipo = :tipo");
        $consulta->bindValue(":tipo", $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchColumn();
    }

    public function valoresInsert() {
        return array(":nombre"=>$this->nombre, ":clave"=>$this->clave, ":tipoUsuarioId"=>$this->tipoUsuarioId);
    }
    public static function obtenerConsultaInsert() {
        return "INSERT INTO Usuario(nombre, clave, tipoUsuarioId) VALUES (:nombre, :clave, :tipoUsuarioId)";
    }
    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Usuario";
    }

    public static function obtenerConsultaSelectPorId() {
        return Usuario::obtenerConsultaSelect() . " WHERE id = :id";
    }
}