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
            try {

                $consulta->bindValue($key, $value, PDO::PARAM_STR);
            }
            catch (Exception $ex) {
                continue;
            }
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

    protected function ejecutarConsultaBindeandoId($query, $id) {
        $TEXTO_BINDEAR_ID = ":id";
        if(str_contains($query, $TEXTO_BINDEAR_ID)) {
            $consulta = $this->accesoDatos->prepararConsulta($query);
            $consulta->bindValue($TEXTO_BINDEAR_ID, $id);
            $consulta->execute();
            return $consulta;
        }
        else {
            throw new Exception("La entidad debe utilizar ':id' para bindear el ID." . PHP_EOL);
        }
    }

}