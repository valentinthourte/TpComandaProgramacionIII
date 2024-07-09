<?php

require_once("services/AService.php");
require_once("model/Usuario.php");
class LoginService extends AService {
    

    public function loguearUsuario($parametros) {
        $nombreUsuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        $usuario = $this->obtenerUsuario($nombreUsuario, $clave);

        if ($usuario) {
            // $this->registrarLoginUsuario($usuario->obtenerId());
            return $this->generarToken($usuario->obtenerTipoUsuario(), $usuario->obtenerId());
        }
        else {
            throw new Exception("Credenciales incorrectas.");
        }

    }

    private function registrarLoginUsuario($id) {
        $query = "INSERT INTO loginsusuario(usuarioId, fechaLogin) values (:id, :fecha)";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $consulta->bindValue(":fecha", date('Y-m-d H:i:s')); 
        $consulta->bindValue(":id", $id);

        $consulta->execute();
    }
    private function obtenerUsuario($nombre, $clave) {
        $query = "SELECT * FROM Usuario WHERE nombre = :nombre AND clave = :clave";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":nombre", $nombre);
        $consulta->bindValue(":clave", $clave);

        $consulta->execute();

        return $consulta->fetchObject(Usuario::class);
    }

    private function generarToken($tipoUsuario, $usuarioId) {
        $data = array('tipoUsuario'=>$tipoUsuario, "usuarioId"=>$usuarioId);
        $token = JWTHelper::crearToken($data);
        return array("token"=>$token);
    }

}