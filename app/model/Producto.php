<?php

require_once("interface/IEntity.php");
class Producto implements IEntity {
    public $id;
    public $nombre;
    public $precio;
    public $tiempoPreparacionBase;
    public $tipoUsuarioPreparacionId;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct4($nombre, $precio, $tiempoPreparacionBase, $tipoUsuarioPreparacion) {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tiempoPreparacionBase = $tiempoPreparacionBase;
        $this->tipoUsuarioPreparacionId = $tipoUsuarioPreparacion;
    }    

    public static function PropiedadAgrupacion() {
        return "tipoUsuarioPreparacionId";
    }

    public function obtenerId() {
        return $this->id;
    }
    public function asignarId($id) {
        $this->id = $id;
    }

    public static function obtenerConsultaInsert() {
        return "INSERT INTO Producto(nombre, precio, tiempoPreparacionBase, tipoUsuarioPreparacionId) VALUES (:nombre,:precio,:tiempoPreparacionBase,:tipoUsuarioPreparacion)";
    }
    public function valoresInsert() {
        return array(":nombre"=>$this->nombre,":precio"=>$this->precio,":tiempoPreparacionBase"=>$this->tiempoPreparacionBase,":tipoUsuarioPreparacion"=>$this->tipoUsuarioPreparacionId);
    }

    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Producto";
    }

    public static function obtenerConsultaSelectPorNombreProducto() {
        return Producto::obtenerConsultaSelect() . " WHERE nombreProducto = :x";
    }
}