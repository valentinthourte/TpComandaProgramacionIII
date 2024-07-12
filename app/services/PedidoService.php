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
    private MesaService $mesaService;

    public function __construct() {
        parent::__construct();
        $this->comandaService = new ComandaService();
        $this->productoService = new ProductoService();
        $this->mesaService = new MesaService();
    }

    public function crearPedido($parametros, $mozoId) {
        $this->validarDatosPedido($parametros);
        $numeroPedido = IdHelper::generarNumeroAlfanumerico($this->LONGITUD_NUMERO_PEDIDO);
        $cliente = $parametros["cliente"]; 
        $fechaHoraInicioPreparacion = empty($parametros["fechaHoraInicioPreparacion"]) ? date('Y-m-d H:i:s') : $parametros["fechaHoraInicioPreparacion"];
        $codigoMesa = $parametros["codigoMesa"];
        $pedido = new Pedido($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $codigoMesa, $mozoId);
        $this->crearEntidad($pedido);
        $productosYCantidades = json_decode($parametros["productos"], true);
        $this->comandaService->crearComandasDePedido($pedido->numeroPedido, $productosYCantidades);
        $this->mesaService->actualizarMesa($codigoMesa, EstadoMesa::ConClienteEsperandoPedido);
        return $numeroPedido;
    }


    private function validarDatosPedido($datos) {
        if (empty($datos["cliente"]) || empty($datos["productos"])) {
            throw new InvalidArgumentException("El cliente o los productos recibidos no son válidos. ");
        }
        $mesa = $this->mesaService->obtenerMesaPorNumero($datos['codigoMesa']);
        if (!$mesa->puedeIniciarPedido()) {
            throw new Exception("El estado de la mesa no permite iniciar un pedido. ");
        }
    }

    public function asociarImagenAPedido($numeroPedido, $imagen) {
        if (!$imagen) {
            throw new Exception("La imagen no fue proporcionada.");
        }
        $pedido = $this->obtenerPedidoPorNumero($numeroPedido);
        if (!$pedido) {
            throw new Exception("No existe pedido con ese numero. ");
        }

        $ruta = $this->subirImagenDeEntidad($pedido, $imagen);
        $pedido->asignarImagen($ruta);

        $query = Pedido::obtenerConsultaUpdateImagen();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":numeroPedido", $numeroPedido);
        $consulta->bindValue(":rutaImagen", $ruta);

        $consulta->execute();

        return $pedido;
    }

    public function obtenerPedidosPorEstado($estado) {
        $query = "SELECT * FROM Pedido WHERE estadoPedido = :estadoPedido";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":estadoPedido", $estado);

        $consulta->execute();

        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);
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

    public function tiempoPorNumeroyMesa($numeroPedido, $numeroMesa) {
        $query = "SELECT * from Pedido where codigoMesa = :numeroMesa and numeroPedido = :numeroPedido";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":numeroPedido", $numeroPedido);
        $consulta->bindValue(":numeroMesa", $numeroMesa);

        $consulta->execute();
        $pedido = $consulta->fetchObject(Pedido::class);
        if (!isset($pedido) || $pedido == false) {
            throw new Exception("No existe pedido con ese codigo para esa mesa. ");
        }
        $pedido->asignarComandas($this->comandaService->obtenerComandasDePedido($numeroPedido));
        
        return (string)$pedido->obtenerTiempoEstimadoPreparacion();
    }
    public function actualizarEstadoPedido($numeroPedido, string $estado) {
        $pedido = $this->obtenerPedidoPorNumero($numeroPedido);

        if (!$pedido) {
            throw new Exception("No existe pedido con ese numero. ");
        }
        try {
            $estadoPedido = EstadoPedido::from($estado);
            $pedido->validarCambioEstado($estadoPedido);
            if ($estadoPedido == EstadoPedido::Servido) {
                $this->mesaService->actualizarMesa($pedido->codigoMesa, EstadoMesa::ConClienteComiendo);
            }
            $pedido->actualizarEstado($estadoPedido);
            $this->actualizarPedido($pedido);
            return $pedido;
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
        if (!isset($pedido) || $pedido == false) {
            throw new Exception("No se encontro pedido con ese numero. ");
        }

        $comandas = $this->comandaService->obtenerComandasDePedido($pedido->numeroPedido);
        $pedido->comandas = $comandas;
        $pedido->monto = $this->obtenerMontoPedido($comandas);

        return $pedido;
    }

    public function verificarEstadoPorComandas($numeroPedido) {
        $pedido = $this->obtenerPedidoPorNumero($numeroPedido);
        if ($pedido->comandasEstanListas()) {
            $this->actualizarEstadoPedido($numeroPedido, EstadoPedido::ListoParaServir->value);
        }
    }

    public function ponerPedidoEnPreparacion($numeroPedido) {
        $pedido = $this->obtenerPedidoPorNumero($numeroPedido);
        if ($pedido->estaEnPreparacion() == false) {
            $this->actualizarEstadoPedido($numeroPedido, EstadoPedido::EnPreparacion->value);
        }
    }

    public function leerPedidosPorFecha($fechaDesde, $fechaHasta) {
        $query = Pedido::obtenerConsultaSelect() . " WHERE fechaHoraInicioPreparacion >= :fechaDesde and fechaHoraInicioPreparacion <= :fechaHasta order by fechaHoraInicioPreparacion desc";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":fechaDesde", $fechaDesde);
        $consulta->bindValue(":fechaHasta", $fechaHasta);
        $consulta->execute();
        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);;
    }


    public function obtenerPedidosPorUsuario($id) {
        if (empty($id)) {
            throw new Exception("El id no fue enviado.");
        }
        $query = "SELECT distinct p.id, p.* FROM Pedido p join comanda c on c.numeroPedido = p.numeroPedido where c.usuarioPreparacionId = :id";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":id", $id);
        $consulta->execute();
        
        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);

    }

    public function obtenerMesaMasUsada(){
        $query = "SELECT p.codigoMesa, COUNT(p.codigoMesa) AS cantidadPedidos FROM Pedido p JOIN Mesa m ON p.codigoMesa = m.numeroMesa GROUP BY p.codigoMesa ORDER BY cantidadPedidos DESC LIMIT 1";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);
        return array("mesa"=>$this->mesaService->leerMesaPorNumero($datos['codigoMesa']), "cantidadPedidos"=>$datos['cantidadPedidos']);
    }
    public function obtenerPedidosDemorados() {
        $query = "SELECT * FROM pedido WHERE DATE_ADD(fechaHoraInicioPreparacion, INTERVAL tiempoEstimadoPreparacion MINUTE) < fechaHoraFinPreparacion";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();
        $pedidos = $consulta->fetchAll(PDO::FETCH_CLASS, Pedido::class);

        return $this->completarInfoPedidos($pedidos);
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