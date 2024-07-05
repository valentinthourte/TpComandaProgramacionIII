<?php

require_once("interface/IEntity.php");
require_once("enums/EstadoComanda.php");

class Comanda implements IEntity {
    public $id;
    public $numeroPedido;
    public $estadoComanda;
    public $usuarioPreparacionId;
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

        public function __construct1($numeroPedido) {
        $this->numeroPedido = $numeroPedido;
        $this->usuarioPreparacionId = null;
        $this->estadoComanda = EstadoComanda::Pendiente;
    }
    public function __construct2($numeroPedido, $usuarioPreparacionId) {
        $this->numeroPedido = $numeroPedido;
        $this->usuarioPreparacionId = $usuarioPreparacionId;
        $this->estadoComanda = EstadoComanda::Pendiente;
    }

    public function __construct3($numeroPedido, $usuarioPreparacionId, $estadoComanda) {
        $this->numeroPedido = $numeroPedido;
        $this->usuarioPreparacionId = $usuarioPreparacionId;
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
            $monto += $producto->precio * $producto->cantidad;
        }
        return $monto;
    }

    public function puedeCambiarDeEstado($estado) {

        return $estado != $this->estadoComanda;
    }
    public function actualizarEstado($estadoComanda) {
        $this->estadoComanda = $estadoComanda;
    }

    public static function obtenerConsultaInsert() {
        return "INSERT INTO Comanda(numeroPedido, estadoComanda, usuarioPreparacionId) VALUES (:numeroPedido, :estadoComanda, :usuarioPreparacionId)";
    }

    public function valoresInsert() {
        return array(":numeroPedido" => $this->numeroPedido, ":estadoComanda"=>$this->estadoComanda->value, ":usuarioPreparacionId"=>$this->usuarioPreparacionId);
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
    public static function obtenerConsultaUpdateEstado() {
        return "UPDATE Comanda SET estadoComanda = :estadoComanda WHERE id = :id";
    }

    public static function obtenerConsultaUpdate() {
        return "UPDATE Comanda SET estadoComanda = :estadoComanda, usuarioPreparacionId = :usuarioPreparacionId where id = :id";
    }

    public function bindearValoresUpdateEstado($consulta) {
        $consulta->bindValue(":estadoComanda", $this->estadoComanda->value);
        $consulta->bindValue(":usuarioPreparacionId", $this->usuarioPreparacionId);
        $consulta->bindValue(":id", $this->id);

        return $consulta;
    }
    public static function obtenerConsultaDeletePorId() {
        return "DELETE FROM Comanda WHERE id = :id";
    }

    public function toHTML(): string {
        $productosHtml = "";
        foreach ($this->productos as $producto) {
            $productosHtml .= $producto->toHTML();
        }

        $indent = str_repeat('&nbsp;', 8);
        return "
        <p>{$indent}- ID Comanda: {$this->id}</p>
        <p>{$indent}- Número de Pedido: {$this->numeroPedido}</p>
        <p>{$indent}- Estado Comanda: {$this->estadoComanda}</p>
        <p>{$indent}- Usuario Preparación Id: {$this->usuarioPreparacionId}</p>
        <p>{$indent}- Tiempo Preparación Estimado: {$this->tiempoPreparacionEstimado}</p>
        <p>{$indent}- Productos: </p>
        $productosHtml
        ";
    }
}