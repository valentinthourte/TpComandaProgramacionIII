<?php

require_once("AService.php");
require_once("helpers/ArrayHelper.php");
require_once("model/ComandaProducto.php");

class ComandaService extends AService {

    private ProductoService $productoService;

    public function __construct() {
        parent::__construct();
        $this->productoService = new ProductoService();
    }
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
        foreach($comanda->obtenerProductos() as $key=>$producto) {
            $comandaProducto = new ComandaProducto($comandaId, $producto->obtenerId());
            $this->crearEntidad($comandaProducto);
            array_push($listaComandaProducto, $comandaProducto);
        }
        return $comanda;
    }

    public function obtenerTiempoEstimadoPreparacion($listaComandas) {
        return ArrayHelper::encontrarMaximoPorPropiedad($listaComandas, "tiempoPreparacionEstimado");
    }

    public function obtenerComandasDePedido($numeroPedido) {
        $query = Comanda::obtenerConsultaSelectPorNumeroPedido();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":x", $numeroPedido, PDO::PARAM_STR);

        $consulta->execute();

        $comandas = $consulta->fetchAll(PDO::FETCH_CLASS, Comanda::class);

        foreach($comandas as $comanda) {
            $comanda->asignarProductos($this->obtenerProductosPorComanda($comanda));
        }
        return $comandas;

    }

    private function obtenerProductosPorComanda($comanda) {

        $query = ComandaProducto::obtenerConsultaSelectPorComandaId();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":x", $comanda->id);

        $consulta->execute();

        $comandaProductos = $consulta->fetchAll(PDO::FETCH_CLASS, ComandaProducto::class);
        $productos = array();
        foreach($comandaProductos as $comandaProducto) {
            $producto = $this->productoService->obtenerProductoPorId($comandaProducto->productoId);
            array_push($productos, $producto);
        }
        return $productos;
    }
} 