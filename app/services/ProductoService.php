<?php

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
}