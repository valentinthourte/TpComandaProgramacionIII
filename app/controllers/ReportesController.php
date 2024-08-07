<?php

require_once("AController.php");
require_once("services/PedidoService.php");
require_once("services/EncuestaService.php");
require_once("services/UsuarioService.php");

class ReportesController extends AController {
    
    private $pedidoService;
    private $encuestaService;
    private $usuarioService;
    public function __construct() {
        $this->pedidoService = new PedidoService();
        $this->usuarioService = new UsuarioService();
        $this->encuestaService = new EncuestaService();
    }

    public function pedidosDemorados($request, $response, $args) {
        try {
            $pedidos = $this->pedidoService->obtenerPedidosDemorados();
            if (count($pedidos) == 0) {
                $content = json_encode(array("mensaje"=>"No se encontraron pedidos demorados. "));
            }
            else {
                $content = json_encode($pedidos);
            }
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    
    public function pedidosPorUsuario($request, $response, $args) {
        try {

            $pedidos = $this->pedidoService->obtenerPedidosPorUsuario($args['id']);
            $content = json_encode($pedidos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function mejoresComentarios($request, $response, $args) {
        try {

            $comentarios = $this->encuestaService->obtenerMejoresComentarios();
            $content = json_encode($comentarios);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    

    public function mesaMasUsada($request, $response, $args) {
        try {
            $datos = $this->pedidoService->obtenerMesaMasUsada();
            $content = json_encode($datos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function cantidadPedidosPorUsuario($request, $response, $args) {
        try {
            $id = $args['id'];
            $pedidos = $this->pedidoService->obtenerPedidosPorUsuario($id);
            $usuario = $this->usuarioService->obtenerUsuarioPorId($id);
            $content = json_encode(array("usuario"=>$usuario, "cantidadPedidos"=>count($pedidos)));
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

}