<?php
require_once("AController.php");

abstract class UsuarioController extends AController {
    protected UsuarioService $usuarioService;
    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

}