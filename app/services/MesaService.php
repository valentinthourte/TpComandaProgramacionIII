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

    public function leerMesaPorNumero($numeroMesa): Mesa {
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

    public function obtenerMesaPorNumero($codigoMesa): Mesa {
        $mesa = $this->leerMesaPorNumero($codigoMesa);
        return $mesa;
    }

    public function actualizarMesa($numeroMesa, $estado, $tipoUsuario = TipoUsuario::Socio) {
        $mesa = $this->leerMesaPorNumero($numeroMesa);
        $estado = gettype($estado) == "string" ? EstadoMesa::from($estado) : $estado;
        $mensaje = "";
        switch($estado) {
            case EstadoMesa::ConClienteEsperandoPedido:
                if (!$mesa->puedeIniciarPedido()) {
                    $mensaje = "La mesa debe estar cerrada para iniciar un pedido.";
                }
                break;
            case EstadoMesa::ConClienteComiendo:
                if (!$mesa->sePuedeServirPedido()) {
                    $mensaje = "El cliente debe estar esperando su pedido para servirlo.";
                }
                break;
            case EstadoMesa::ConClientePagando:
                if (!$mesa->puedeCobrarCuenta()) {
                    $mensaje = "El cliente debe estar comiendo para cobrar la cuenta. ";
                }
                break;
            case EstadoMesa::Cerrada:
                if (!$mesa->puedeCerrarse() || $tipoUsuario != TipoUsuario::Socio) {
                    $mensaje = "La mesa no puede cerrarse. ";
                }
                break;
            case EstadoMesa::Baja:
                break;
        }
        if ($mensaje != "") {
            throw new Exception($mensaje);
        }
        $query = "UPDATE Mesa SET estado = :estado where numeroMesa = :numeroMesa";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":estado", gettype($estado) != "string" ? $estado->value : $estado);
        $consulta->bindValue(":numeroMesa", $numeroMesa);
        $consulta->execute();

        return $this->leerMesaPorNumero($numeroMesa);
    }

}