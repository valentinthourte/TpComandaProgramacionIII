<?php

require_once("interface/IEntity.php");
require_once("enums/EstadoComanda.php");

class Comanda implements IEntity {
    public $id;
    public $numeroPedido;
    public $estadoComanda;
    public $tipoUsuarioPreparacionId;
    public $productos;
    public $tiempoPreparacionEstimado;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct2($numeroPedido, $tipoUsuarioPreparacionId) {
        $this->numeroPedido = $numeroPedido;
        $this->tipoUsuarioPreparacionId = $tipoUsuarioPreparacionId;
        $this->estadoComanda = EstadoComanda::Pendiente;
    }

    public function __construct3($numeroPedido, $tipoUsuarioPreparacionId, $estadoComanda) {
        $this->numeroPedido = $numeroPedido;
        $this->tipoUsuarioPreparacionId = $tipoUsuarioPreparacionId;
        $this->estadoComanda = $estadoComanda;
    }

    public function asignarId($id) {
        $this->id = $id;
    }

    public function obtenerProductos() {
        return $this->productos;
    }

    public function asignarProductos($productos) {
        $this->productos = $productos;
    }

    public function obtenerMonto() {
        $monto = 0;
        foreach($this->productos as $producto) {
            $monto += $producto->precio;
        }
        return $monto;
    }

    public static function obtenerConsultaInsert() {
        return "INSERT INTO Comanda(numeroPedido, estadoComanda, tipoUsuarioPreparacionId) VALUES (:numeroPedido, :estadoComanda, :tipoUsuarioPreparacionId)";
    }

    public function valoresInsert() {
        return array(":numeroPedido" => $this->numeroPedido, ":estadoComanda"=>$this->estadoComanda->value, ":tipoUsuarioPreparacionId"=>$this->tipoUsuarioPreparacionId);
    }

    public static function obtenerConsultaSelect()
    {
        return "SELECT * FROM Comanda";
    }

    public static function obtenerConsultaSelectPorId() {
        return Comanda::obtenerConsultaSelect() . " WHERE id = :id";
    }

    public static function obtenerConsultaSelectPorNumeroPedido() {
        return Comanda::obtenerConsultaSelect() . " WHERE numeroPedido = :x";
    }


}