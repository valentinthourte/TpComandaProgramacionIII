<?php


use Dompdf\Dompdf;
require_once("model/Producto.php");
require_once("services/ComandaService.php");
require_once("services/ProductoService.php");
require_once("helpers/ArrayHelper.php");
require_once("helpers/IdHelper.php");

class PedidoService extends AService {
    private $LONGITUD_NUMERO_PEDIDO = 5;
    private ComandaService $comandaService;
    private ProductoService $productoService;

    public function __construct() {
        parent::__construct();
        $this->comandaService = new ComandaService();
        $this->productoService = new ProductoService();
    }

    public function crearPedido($parametros) {
        $this->validarDatosPedido($parametros);
        $numeroPedido = IdHelper::generarNumeroAlfanumerico($this->LONGITUD_NUMERO_PEDIDO);
        $listaProductos = $this->productoService->parsearProductos(json_decode($parametros["productos"]));
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

    public function leerPedidos($estado = "") {
        $query = empty($estado) ? Pedido::obtenerConsultaSelect() : Pedido::obtenerConsultaSelectPorEstado();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        if (!empty($estado)) {
            $consulta->bindValue(":estado", $estado);
        }
        $consulta->execute();

        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);
    }

    private function completarInfoPedidos($pedidos) {
        foreach($pedidos as $pedido) {
            $comandas = $this->comandaService->obtenerComandasDePedido($pedido->numeroPedido);
            $pedido->comandas = $comandas;
            $pedido->monto = $this->obtenerMontoPedido($comandas);
        }
        return $pedidos;
    }
    private function obtenerMontoPedido($comandas) {
        $monto = 0;
        foreach ($comandas as $comanda) {
            $monto += $comanda->obtenerMonto();
        }
        return $monto;
    }

    public function actualizarEstadoPedido($numeroPedido, $estado) {
        $pedido = $this->obtenerPedidoPorNumero($numeroPedido);

        if (!$pedido) {
            throw new Exception("No existe pedido con ese numero. ");
        }
        try {
            $estadoPedido = EstadoPedido::from($estado);
            if ($pedido->puedeCambiarDeEstado($estado)) {
                $pedido->actualizarEstado($estadoPedido);
                $this->actualizarPedido($pedido);
                return $pedido;
            }
            else {
                throw new Exception("El estado debe ser diferente al actual o las comandas no estan listas.");
            }
            
        }
        catch (ValueError $ex) {
            throw new Exception("El estado enviado no es válido: " . $estado, 404, $ex);
        }
    }

    public function actualizarPedido($pedido) {
        $query = Pedido::obtenerConsultaUpdateEstado();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta = $pedido->bindearValoresUpdateEstado($consulta);

        $consulta->execute();
        
    }

    public function obtenerPedidoPorNumero($numeroPedido): Pedido {
        $query = Pedido::obtenerConsultaSelect() . " WHERE numeroPedido = :numeroPedido";
        $consulta = $this->accesoDatos->prepararConsulta($query);

        $consulta->bindValue(":numeroPedido", $numeroPedido);
        $consulta->execute();
        $pedido = $consulta->fetchObject(Pedido::class);

        $comandas = $this->comandaService->obtenerComandasDePedido($pedido->numeroPedido);
        $pedido->comandas = $comandas;
        $pedido->monto = $this->obtenerMontoPedido($comandas);

        return $pedido;
    }

    public function leerPedidosPorFecha($fechaDesde, $fechaHasta) {
        $query = Pedido::obtenerConsultaSelect() . " WHERE fechaHoraInicioPreparacion >= :fechaDesde and fechaHoraInicioPreparacion <= :fechaHasta";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":fechaDesde", $fechaDesde);
        $consulta->bindValue(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);;
    }
    public function exportarPdfPorFecha($fechaDesde, $fechaHasta) {
        
        $pedidos = $this->leerPedidosPorFecha($fechaDesde, $fechaHasta);
        $html = '<h1>Pedidos</h1>';
        
        foreach ($pedidos as $pedido) {
            $html .= $pedido->toHTML();
        }

        $domPdf = new Dompdf();
        $domPdf->loadHtml($html);
        $domPdf->render();
        return $domPdf->output();
    }
}