<?php


require_once("model/Producto.php");
require_once("services/ComandaService.php");
require_once("helpers/ArrayHelper.php");

class PedidoService extends AService {
    private $LONGITUD_NUMERO_PEDIDO = 5;
    private ComandaService $comandaService;

    public function __construct() {
        parent::__construct();
        $this->comandaService = new ComandaService();
    }

    public function crearPedido($parametros) {
        $this->validarDatosPedido($parametros);
        $numeroPedido = Pedido::generarNumeroPedido($this->LONGITUD_NUMERO_PEDIDO);
        $listaProductos = json_decode($parametros["productos"]);
        $cliente = $parametros["cliente"];
        $listaAgrupada = ArrayHelper::groupBy($listaProductos, Producto::PropiedadAgrupacion()); 
        $fechaHoraInicioPreparacion = empty($parametros["fechaHoraInicioPreparacion"]) ? date('Y-m-d H:i:s') : $parametros["fechaHoraInicioPreparacion"];
        $tiempoPreparacion = ArrayHelper::encontrarMaximoPorPropiedad($listaProductos, "tiempoPreparacionBase")->tiempoPreparacionBase;
        $pedido = new Pedido($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $tiempoPreparacion, $parametros["codigoMesa"]);
        $this->crearEntidad($pedido);
        $this->comandaService->crearComandasDePedido($numeroPedido, $listaAgrupada);
        return $numeroPedido;
    }

    private function validarDatosPedido($datos) {
        if (empty($datos["cliente"]) || empty($datos["productos"])) {
            throw new InvalidArgumentException("El cliente o los productos recibidos no son válidos. ");
        }
    }
}