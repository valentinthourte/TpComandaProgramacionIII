<?php

class LoginUsuario {
    public $usuario;
    public $fechaLogin;

    public function __construct($usuario, $fechaLogin) {
        $this->usuario = $usuario;
        $this->fechaLogin = $fechaLogin;
    }
}