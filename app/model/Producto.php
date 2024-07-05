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

    public function __construct1($data) {
        $this->nombre = $data['nombre'];
        $this->precio = $data['precio'];
        $this->tiempoPreparacionBase = $data['tiempoPreparacionBase'];
        $this->tipoUsuarioPreparacionId = $data['tipoUsuarioPreparacionId'];
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

    public static function obtenerConsultaUpdate() {
        return "UPDATE Producto SET nombre = :nombre, precio = :precio, tiempoPreparacionBase = :tiempoPreparacionBase, tipoUsuarioPreparacionId = :tipoUsuarioPreparacionId where id = :id";
    }

    public static function obtenerCabecerasCsv() {
        return ['nombre', 'precio', 'tiempoPreparacionBase', 'tipoUsuarioPreparacionId'];
    }

    public function toCsv() {
        return [$this->nombre, (string)$this->precio, (string)$this->tiempoPreparacionBase, (string)$this->tipoUsuarioPreparacionId];
    }

    public function actualizarInfo($nombre, $precio, $tiempoPreparacionBase, $tipoUsuarioPreparacion) {
        $this->nombre = empty($nombre) ? $this->nombre : $nombre;
        $this->precio = empty($precio) ? $this->precio : $precio;
        $this->tiempoPreparacionBase = empty($tiempoPreparacionBase) ? $this->tiempoPreparacionBase : $tiempoPreparacionBase;
        $this->tipoUsuarioPreparacionId = empty($tipoUsuarioPreparacion) ? $this->tipoUsuarioPreparacionId : $tipoUsuarioPreparacion;
    }

    public function bindearValoresUpdate($consulta) {
        $consulta->bindValue(":id", $this->id);
        $consulta->bindValue(":nombre", $this->nombre);
        $consulta->bindValue(":precio", $this->precio);
        $consulta->bindValue(":tiempoPreparacionBase", $this->tiempoPreparacionBase);
        $consulta->bindValue(":tipoUsuarioPreparacionId", $this->tipoUsuarioPreparacionId);
        return $consulta;
    }
    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Producto";
    }

    public static function obtenerConsultaSelectPorNombreProducto() {
        return Producto::obtenerConsultaSelect() . " WHERE nombreProducto = :x";
    }

    public static function obtenerConsultaSelectPorId() {
        return Producto::obtenerConsultaSelect() . " WHERE id = :id";
    }

    public static function obtenerConsultaDeletePorId() {
        return "DELETE FROM Producto WHERE id = :id";
    }

    public function toHTML(): string {
        $indent = str_repeat('&nbsp;', 16);
        return "
        <p>{$indent}- Producto: {$this->nombre}</p>
        <p>{$indent}- Precio: {$this->precio}</p>
        <p>{$indent}- Tiempo de Preparación Base: {$this->tiempoPreparacionBase}</p>
        <p>{$indent}- Tipo Usuario Preparación Id: {$this->tipoUsuarioPreparacionId}</p>
        ";
    }
}