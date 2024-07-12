<?php
require_once("model/Producto.php");
require_once("services/ProductoService.php");
class ProductoController extends AController {
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
        $producto = new Producto($nombre, $precio, $tiempoPreparacionBase, $tipoUsuarioPreparacion);
        try {
            $id = $this->productoService->crearProducto($producto);
    
            $respuesta = json_encode(array("mensaje"=>"Producto creado con éxito", "id"=>$id));
            return $this->setearResponse($response, $respuesta);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function exportarACsv($request, $response, $args) {
        try {
            $archivo = $this->productoService->exportarProductosACsv();
            $contenido = file_get_contents($archivo);
            unlink($archivo);
            
            return $this->setearResponse($response, $contenido, 'text/csv')->withHeader('Content-Disposition', 'attachment; filename="productos.csv"');
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
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
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function cargaMasiva($request, $response, $args) {
        try {

            $archivo = $request->getUploadedFiles()['productos'];
            $errores = $this->productoService->cargarProductosMasivamente($archivo);
            if (count($errores) == 0) {
                $errores = array("Todos los productos fueron cargados correctamente. ");
            }
            $content = json_encode(array("mensaje"=>$errores));
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function leerUno($request, $response, $args){
        try {
            $id = $args['id'];
            $producto = $this->productoService->obtenerProductoPorId($id);
            $content = json_encode($producto);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }
    public function actualizar($request, $response, $args){
        try {
            $parametros = $request->getParsedBody();
            $id = $args['id'];
            $producto = $this->productoService->actualizarProducto($id, $parametros);
            $content = json_encode($producto);
            return $this->setearResponse($response, $content);
        }
        catch (Exception $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
        catch (Error $e) {
            return $this->setearResponseError($response, $e->getMessage(), 400);
        }
    }

    public function eliminar($request, $response, $args){
        try {
           $id = $request->getQueryParams()['id'] ?? $args['id']; 
           $mensaje = $this->productoService->eliminarProducto($id);
           $content = json_encode(array("mensaje"=>$mensaje));
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