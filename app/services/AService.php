<?php

require_once("../db/AccesoDatos.php");

abstract class AService {
    protected AccesoDatos $accesoDatos;
    public function __construct() {
        $this->accesoDatos = AccesoDatos::obtenerInstancia();
    }

    protected function crearEntidad(IEntity $entidad) {
        $consulta = $this->accesoDatos->prepararConsulta($entidad->obtenerConsultaInsert());
        foreach($entidad->valoresInsert() as $key=>$value) {
            $consulta->bindValue($key, $value, PDO::PARAM_STR);
        }
        try {
            $consulta->execute();
        }
        catch(PDOException $e) {
            
            if (str_contains($e->getMessage(), "Duplicate entry")){
                throw new Exception("Error al insertar en base de datos: registro duplicado.-" . $e->getMessage());
            }
            else 
                throw $e;
        }
        return $this->accesoDatos->obtenerUltimoId();
    }

}