<?php

require_once("../db/AccesoDatos.php");
require_once("model/Usuario.php");
require_once("services/AService.php");

class UsuarioService extends AService {


    public function obtenerUsuariosPorTipo($tipo_usuario, $soloActivos = true) {
        $tipo_usuario_id = $this->obtenerIdTipoUsuarioPorNombre($tipo_usuario);
        $textoConsulta = "SELECT * FROM Usuario where TipoUsuarioId = :tipoUsuarioId ";
        $condicionActivos = "&& fechaBaja is null";
        if ($soloActivos) {
            $textoConsulta = $textoConsulta . $condicionActivos;
        }
        $consulta_usuario = $this->accesoDatos->prepararConsulta($textoConsulta);
        $consulta_usuario->bindValue(":tipoUsuarioId", $tipo_usuario_id, PDO::PARAM_STR);
        $consulta_usuario->execute();

        return $consulta_usuario->fetchAll(PDO::FETCH_CLASS, $tipo_usuario);

    }

    public function obtenerUsuarioPorId($id_usuario) {
        $consulta = $this->accesoDatos->prepararConsulta("SELECT * FROM Usuario where id = :id");
        $consulta->bindValue(":id", $id_usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject("Usuario");
    }

    public function crearUsuario(Usuario $usuario){
        return $this->crearEntidad($usuario);
    }

    public function obtenerIdTipoUsuarioPorNombre($nombreTipoUsuario) {
        $consulta = $this->accesoDatos->prepararConsulta("SELECT id FROM TipoUsuario WHERE tipo = :tipo");
        $consulta->bindValue(":tipo", $nombreTipoUsuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchColumn();
    }

    public function desactivarUsuario($idEliminar) {
        $consulta = $this->accesoDatos->prepararConsulta("UPDATE Usuario SET fechaBaja = :fechaBaja where id = :id");
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $consulta->bindValue(":fechaBaja", date('Y-m-d H:i:s')); 
        $consulta->bindValue(":id", $idEliminar);
        
        $consulta->execute();
    }
}