<?php

require_once("interface/IEntity.php");
class ComandaProducto implements IEntity {
    public $comandaId;
    public $productoId;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct2($comandaId, $productoId) {
        $this->comandaId = $comandaId;
        $this->productoId = $productoId;
    }

    public static function obtenerConsultaInsert() {
        return "INSERT INTO ComandaProducto(comandaId, productoId) VALUES (:comandaId, :productoId)";
    } 
    public static function obtenerConsultaSelect()
    {
        return "SELECT * FROM ComandaProducto";
    }

    public static function obtenerConsultaSelectPorComandaId() {
        return ComandaProducto::obtenerConsultaSelect() . " WHERE comandaId = :x";
    }
    public function valoresInsert() {
        return array(":comandaId"=>$this->comandaId, ":productoId"=>$this->productoId);
    }

    public static function obtenerConsultaSelectPorId() {
        return ComandaProducto::obtenerConsultaSelect() . " WHERE comandaId = :comandaId AND productoId = :productoId";
    }

}