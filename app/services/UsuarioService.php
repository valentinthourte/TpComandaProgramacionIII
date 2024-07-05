<?php

require_once("../db/AccesoDatos.php");
require_once("model/Usuario.php");
require_once("model/LoginUsuario.php");
require_once("services/AService.php");

class UsuarioService extends AService {

    public function obtenerUsuariosPorTipo($tipo_usuario = "", $soloActivos = true) {
        $tipo_usuario_id = $this->obtenerIdTipoUsuarioPorNombre($tipo_usuario);
        $textoConsulta = Usuario::obtenerConsultaSelect();

        $condicionTipo = " tipoUsuarioId = :tipoUsuarioId";
        $condicionActivos = " fechaBaja is null";

        if (!empty($tipo_usuario)) {
            $textoConsulta = $textoConsulta . $this->obtenerConectorCondicionSQL($textoConsulta) . $condicionTipo; // Agrego condiciones
        } 
        $textoConsulta = $soloActivos ? $textoConsulta . $this->obtenerConectorCondicionSQL($textoConsulta) . $condicionActivos : $textoConsulta;

        $consulta_usuario = $this->accesoDatos->prepararConsulta($textoConsulta);
        if (!empty($tipo_usuario)) {
            $consulta_usuario->bindValue(":tipoUsuarioId", $tipo_usuario_id, PDO::PARAM_STR);
        }
        $consulta_usuario->execute();

        return $consulta_usuario->fetchAll(PDO::FETCH_CLASS, Usuario::class);

    }

    public function obtenerUsuarioPorId($id_usuario) {
        $consulta = $this->ejecutarConsultaBindeandoId(Usuario::obtenerConsultaSelectPorId(), $id_usuario);

        $usuario = $consulta->fetchObject(Usuario::class);
        return $usuario;
    }
    

    public function obtenerLogins($fechaDesde, $fechaHasta) {
        $query = "SELECT u.*, lu.fechaLogin FROM Usuario u join loginsusuario lu on lu.usuarioId = u.id where lu.fechaLogin >= :fechaDesde AND lu.fechaLogin <= :fechaHasta";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":fechaDesde", $fechaDesde);
        $consulta->bindValue(":fechaHasta", $fechaHasta);

        $consulta->execute();

        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $logins = [];
    
        foreach ($resultados as $fila) {
            $usuario = new Usuario($fila); 
            $fechaLogin = $fila['fechaLogin'];
            $logins[] = new LoginUsuario($usuario, $fechaLogin);
        }
    
        return $logins;
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
        $usuario = $this->obtenerUsuarioPorId($idEliminar);
        if ($usuario) {
            if ($usuario->estaDadoDeBaja()) {
                $consulta = $this->accesoDatos->prepararConsulta("DELETE FROM Usuario WHERE id = :id");
            }
            else {
                $consulta = $this->accesoDatos->prepararConsulta("UPDATE Usuario SET fechaBaja = :fechaBaja where id = :id");
                date_default_timezone_set("America/Argentina/Buenos_Aires");
                $consulta->bindValue(":fechaBaja", date('Y-m-d H:i:s')); 
            }
            $consulta->bindValue(":id", $idEliminar);
            
            $consulta->execute();

            return "Usuario dado de baja correctamente";
        }
        else {
            return "No existe usuario con ese ID.";
        }
    }

    public function obtenerConectorCondicionSQL($textoConsulta) {
        return str_contains(strtolower($textoConsulta), "where") ? "AND" : "WHERE";
    }
}