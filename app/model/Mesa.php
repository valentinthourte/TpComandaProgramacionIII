<?php

require_once("interface/IEntity.php");
require_once("enums/EstadoMesa.php");

class Mesa implements IEntity {

    public $numeroMesa;
    public $estado;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct1($numeroMesa) {
        $this->numeroMesa = $numeroMesa;
        $this->estado = EstadoMesa::Cerrada;
    }    
    
    public function __construct2($numeroMesa, $estado) {
        $this->numeroMesa = $numeroMesa;
        $this->estado = $estado;
    }    

    public function puedeIniciarPedido() {
        return $this->estaEnEstado(EstadoMesa::Cerrada);
    }

    public function puedeCobrarCuenta() {
        return $this->estaEnEstado(EstadoMesa::ConClienteComiendo);
    }

    public function sePuedeServirPedido() {
        return $this->estaEnEstado(EstadoMesa::ConClienteEsperandoPedido);
    }

    public function puedeCerrarse() {
        return $this->estaEnEstado(EstadoMesa::ConClientePagando);
    }

    public function puedeRecibirComentarios() {
        return $this->estaEnEstado(EstadoMesa::Cerrada);
    }
    private function estaEnEstado($estado) {
        $estadoMesa = gettype($this->estado) == "string" ? EstadoMesa::from($this->estado) : $this->estado;
        return $estadoMesa == $estado;
    }
    
    public function valoresInsert() {
        return array(":numeroMesa"=>$this->numeroMesa, ":estado"=>$this->estado->value);
    }
    public static function obtenerConsultaInsert() {
        return "INSERT INTO MESA(numeroMesa, estado) VALUES(:numeroMesa, :estado)";
    }
    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Mesa";
    }
    public static function obtenerConsultaSelectPorId() {
        return Mesa::obtenerConsultaSelect() . " WHERE id = :id";

    }

    public function obtenerNombreImagen() {
        return "Mesa-" . $this->numeroMesa;
    }
    
    public static function obtenerConsultaDeletePorId() {
        return "DELETE FROM Mesa WHERE numeroMesa = :numeroMesa";
    }

}