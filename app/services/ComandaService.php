<?php


require_once("AService.php");
require_once("helpers/ArrayHelper.php");

class ComandaService extends AService {

    public function crearComandasDePedido($numeroPedido, $productosAgrupados) {
        $comandas = array();
        $comandasProductos = array();
        foreach($productosAgrupados as $sector=>$productos) {
            $comanda = new Comanda($numeroPedido, $sector);
            $comanda->asignarProductos($productos);
            $comanda = $this->guardarComanda($comanda);
            array_push($comandas, $comanda);
        }
        return $comandas;
    }

    private function guardarComanda(Comanda $comanda) {
        $comandaId = $this->crearEntidad($comanda);
        $comanda->asignarId($comandaId);
        $listaComandaProducto = array();
        
        foreach($comanda->obtenerProductos() as $producto) {
            $comandaProducto = new ComandaProducto($comandaId, $producto->obtenerId());
            $this->crearEntidad($comandaProducto);
            array_push($listaComandaProducto, $comandaProducto);
        }
        return $comandaProducto;
    }

    public function obtenerTiempoEstimadoPreparacion($listaComandas) {
        return ArrayHelper::encontrarMaximoPorPropiedad($listaComandas, "tiempoPreparacionEstimado");
    }
} 