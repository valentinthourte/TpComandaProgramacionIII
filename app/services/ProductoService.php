<?php

require_once("../db/AccesoDatos.php");
require_once("model/Producto.php");
require_once("services/AService.php");
class ProductoService extends AService {

    public function obtenerProductoPorNombre(string $nombreProducto) {
        $queryProductoPorNombre = Producto::obtenerConsultaSelectPorNombreProducto();
        $consulta = $this->accesoDatos->prepararConsulta($queryProductoPorNombre);
        $consulta->bindValue(":x", $nombreProducto); // No se si es correcto utilizar :x como genérico, no se me ocurre en ese momento como encararlo

        $consulta->execute();

        return $consulta->fetchObject("Producto");
    }

    public function crearProducto(Producto $producto) {
        return $this->crearEntidad($producto);
    }

    public function leerProductos() {
        $query = Producto::obtenerConsultaSelect();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, Producto::class);
    }

    public function parsearProductos($array) {
        $productos = array();
        foreach($array as $productoJson) {
            $producto = new Producto($productoJson->nombre, $productoJson->precio, $productoJson->tiempoPreparacionBase, $productoJson->tipoUsuarioPreparacionId);
            $producto->asignarId($productoJson->id);
            array_push($productos, $producto);
        }
        return $productos;
    }

    public function obtenerProductoPorId($id) {

        $consulta = $this->ejecutarConsultaBindeandoId(Producto::obtenerConsultaSelectPorId(), $id);
        return $consulta->fetchObject(Producto::class);
    }

    public function cargarProductosMasivamente($archivo) {
        if ($archivo->getError() !== UPLOAD_ERR_OK) {
            throw new Exception("El archivo no se subio correctamente");
        }
        $stream = $archivo->getStream();
        $stream->rewind();
        $contenido = $stream->getContents();

        $lineas = explode(PHP_EOL, $contenido);
        $cabeceras = [];
        $listaErrores = [];
        foreach($lineas as $indice=>$linea) {
            if (trim($linea) == '') {
                continue;
            }
            $datos = str_getcsv($linea);
            if ($indice == 0) {
                $cabeceras = $datos;
            }
            else {
                $dataProducto = array_combine($cabeceras, $datos);
                $producto = new Producto($dataProducto); 
                try {

                    $this->crearProducto($producto);
                }
                catch (Exception $ex) {
                    array_push($listaErrores, $ex->getMessage());
                }
            }
        }
        return $listaErrores;
    }

    public function eliminarProducto($id) {
        $this->validarProductoExiste($id);
        try {

            $query = Producto::obtenerConsultaDeletePorId();
            $consulta = $this->accesoDatos->prepararConsulta($query);
            $consulta->bindValue(":id", $id);
            $consulta->execute();
            return "Producto eliminado correctamente";
        }
        catch (Exception $ex) {
            return "Se produjo un error al eliminar el producto: " . $ex->getMessage();
        }
    }

    public function exportarProductosACsv() {
        $nombreArchivo = tempnam(sys_get_temp_dir(), 'productos_');

        $csv = fopen($nombreArchivo, "w");

        fputcsv($csv, Producto::obtenerCabecerasCsv());

        $productos = $this->leerProductos();
        foreach($productos as $producto) {
            fputcsv($csv, $producto->toCsv());
        }
        fclose($csv);
        return $nombreArchivo;
    }

    public function actualizarProducto($id, $parametros) {
        $producto = $this->validarProductoExiste($id);

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $tiempoPreparacionBase = $parametros['tiempoPreparacionBase'];
        $tipoUsuarioPreparacion = $parametros['tipoUsuarioPreparacionId'];
        $producto->actualizarInfo($nombre, $precio, $tiempoPreparacionBase, $tipoUsuarioPreparacion);

        $query = Producto::obtenerConsultaUpdate();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $producto->bindearValoresUpdate($consulta);
        $consulta->execute();

        return $producto;
    }

    private function validarProductoExiste($id) {
        $producto = $this->obtenerProductoPorId($id);
        if (!$producto) {
            throw new Exception("El producto no existe.");
        }
        return $producto;
    }
}