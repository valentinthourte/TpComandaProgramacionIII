<?php

require_once("interface/IEntity.php");
class ComandaProducto implements IEntity {
    private $comandaId;
    private $productoId;

    public function __construct($comandaId, $productoId) {
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

    public function valoresInsert() {
        return array(":comandaId"=>$this->comandaId, ":productoId"=>$this->productoId);
    }

}