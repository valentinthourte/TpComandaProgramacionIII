<?php

interface IController {

    public function crearUno($request, $response, $args);
    public function leerTodos($request, $response, $args);
    public function leerUno($request, $response, $args);
    public function actualizar($request, $response, $args);
    public function eliminar($request, $response, $args);
}