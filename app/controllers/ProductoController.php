<?php
require_once("interface/IController.php");
require_once("model/Producto.php");
require_once("services/ProductoService.php");
class ProductoController extends AController implements IController {
    private ProductoService $productoService;
    public function __construct() {
        $this->productoService = new ProductoService();
    }

    public function crearUno($request, $response, $args){
        $parametros = $request->getParsedBody();
        $nombre = $parametros["nombre"];
        $precio = $parametros["precio"];
        $tiempoPreparacionBase = $parametros["tiempoPreparacionBase"];
        $tipoUsuarioPreparacion = $parametros["tipoUsuarioPreparacion"];
        $producto = new Producto( $nombre, $precio, $tiempoPreparacionBase, $tipoUsuarioPreparacion);
        try {
            $id = $this->productoService->crearProducto($producto);
    
            $respuesta = json_encode(array("mensaje"=>"Producto creado con éxito", "id"=>$id));
            return $this->setearResponse($response, $respuesta);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function leerTodos($request, $response, $args){
        try {

            $productos = $this->productoService->leerProductos();
            $content = json_encode($productos);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function leerUno($request, $response, $args){

    }
    public function actualizar($request, $response, $args){

    }
    public function eliminar($request, $response, $args){

    }
}