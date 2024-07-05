<?php

require_once("helpers/IdHelper.php");
require_once("model/Mesa.php");

class MesaService extends AService {
    public function crearMesa($numeroMesa = null) {
        $LONGITUD_ID_MESA = 5;
        $numeroMesa = empty($numeroMesa) ? IdHelper::generarNumeroAlfanumerico($LONGITUD_ID_MESA) : $numeroMesa;
        $mesa = new Mesa($numeroMesa);

        $this->crearEntidad($mesa);
        return $numeroMesa;
    }

    public function leerMesas() {
        $query = Mesa::obtenerConsultaSelect();

        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, Mesa::class);
    }

    public function leerMesaPorNumero($numeroMesa) {
        $query = "SELECT * FROM Mesa WHERE numeroMesa = :numeroMesa";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":numeroMesa", $numeroMesa);
        $consulta->execute();

        return $consulta->fetchObject(Mesa::class);
    }
    public function eliminarMesa($numeroMesa) {
        try {

            $mesa = $this->leerMesaPorNumero($numeroMesa);
            if ($mesa) {
                $this->actualizarMesa($numeroMesa, EstadoMesa::Baja->value);
                return "Mesa dada de baja con exito";
            }
            else {
                return "La mesa no existe";
            }
        }
        catch (Exception $ex) {
            throw new Exception("No se pudo eliminar la mesa: " . $ex->getMessage(), 400, $ex);
        } 
    }

    public function actualizarMesa($numeroMesa, $estado,$tipoUsuario = TipoUsuario::Socio) {
        if ($estado == EstadoMesa::Cerrada->value && $tipoUsuario == TipoUsuario::Mozo) {
            throw new Exception("Solo un socio puede marcar la mesa como cerrada.");
        }
        $query = "UPDATE Mesa SET estado = :estado where numeroMesa = :numeroMesa";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":estado", $estado);
        $consulta->bindValue(":numeroMesa", $numeroMesa);
        $consulta->execute();

        return $this->leerMesaPorNumero($numeroMesa);
    }

}