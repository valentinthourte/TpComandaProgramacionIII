<?php 
require_once("model/Comanda.php");
require_once("model/Producto.php");
require_once("services/ComandaService.php");
require_once("helpers/ArrayHelper.php");
require_once("interface/IEntity.php");
require_once("enums/EstadoPedido.php");


class Pedido implements IEntity {
    public $numeroPedido; // como hago para mapear sin hacer todos los miembros publicos?
    public $comandas;
    public $cliente;
    public $fechaHoraInicioPreparacion;
    public $tiempoEstimadoPreparacion;
    public $codigoMesa;
    public $estadoPedido;
    
    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct6($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $tiempoEstimadoPreparacion, $codigoMesa, $estadoPedido) {
        $this->numeroPedido = $numeroPedido;
        $this->cliente = $cliente;
        $this->fechaHoraInicioPreparacion = $fechaHoraInicioPreparacion;
        $this->tiempoEstimadoPreparacion = $tiempoEstimadoPreparacion;
        $this->codigoMesa = $codigoMesa;
        $this->estadoPedido = match ($estadoPedido) {
            "Pendiente" => EstadoPedido::Pendiente,
            "EnPreparacion" => EstadoPedido::EnPreparacion,
            "ListoParaServir" => EstadoPedido::ListoParaServir
        };
        // $this->estadoPedido = EstadoPedido::Pendiente;
    }

    public static function generarNumeroPedido($tamaño) {
        $numeroPedido = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyz0123456789";
        for($i = 0; $i < $tamaño; $i++) {
            $numeroPedido = $numeroPedido . substr(str_shuffle($caracteres), 0, 1);
        }
        return $numeroPedido;
    }
    
    public function valoresInsert() {
        return array(":numeroPedido"=>$this->numeroPedido, ":cliente"=>$this->cliente, ":fechaHoraInicioPreparacion"=>$this->fechaHoraInicioPreparacion, ":tiempoEstimadoPreparacion"=>$this->tiempoEstimadoPreparacion, ":codigoMesa"=>$this->codigoMesa, ":estadoPedido"=>$this->estadoPedido->value);
    }
    
    public static function obtenerConsultaInsert() {
        return "INSERT INTO Pedido(numeroPedido, cliente, fechaHoraInicioPreparacion, tiempoEstimadoPreparacion, codigoMesa, estadoPedido) VALUES (:numeroPedido,:cliente,:fechaHoraInicioPreparacion,:tiempoEstimadoPreparacion,:codigoMesa,:estadoPedido)";
    }

    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Pedido";
    }

    public static function obtenerConsultaSelectPorId()
    {
        return Pedido::obtenerConsultaSelect() . " WHERE id = :id";
    }
}