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
    public function crearComandasDePedido($numeroPedido, $productosIds) {
        $comandas = array();
        $comandasProductos = array();
        $listaProductos = $this->productoService->obtenerProductosPorId($productosIds);
        $listaAgrupada = ArrayHelper::groupBy($listaProductos, Producto::PropiedadAgrupacion());
        foreach($listaAgrupada as $tipoUsuarioId=>$productos) {
            $comanda = new Comanda($numeroPedido);
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
            $producto->cantidad = $comandaProducto->cantidad;
            array_push($productos, $producto);
        }
        return $productos;
    }

    public function actualizarEstadoComanda($numeroPedido, $tipoUsuario, $usuarioId, $estado, $tiempoEstimado) {
        $comanda = $this->obtenerComandaPorNumeroPedidoYTipoUsuario($numeroPedido, $tipoUsuario);
        if (!$comanda) {
            throw new Exception("No existe una comanda con ese numeroPedido y sector");
        }
        $estadoComanda = EstadoComanda::from($estado);
        if ($comanda->puedeCambiarDeEstado($estado)) {
            $comanda->actualizarEstado($estadoComanda);
            if ($estadoComanda == EstadoComanda::EnPreparacion) {
                $comanda->tiempoPreparacionEstimado = $tiempoEstimado;
                $comanda->usuarioPreparacionId = $usuarioId;
            }
            $this->actualizarComanda($comanda);
        }
        else {
            throw new Exception("El estado debe ser diferente al actual");
        }
        return $comanda;
    }

    private function obtenerComandaPorNumeroPedidoYTipoUsuario($numeroPedido, $tipoUsuario): Comanda | bool {
        $query = "SELECT distinct c.id, c.* FROM Comanda c join comandaproducto cp on cp.comandaId = c.id join producto p on p.id = cp.productoId where c.numeroPedido = :numeroPedido and p.tipoUsuarioPreparacionId = :tipoUsuario";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":numeroPedido", $numeroPedido);
        $consulta->bindValue(":tipoUsuario", $tipoUsuario->value);
        $consulta->execute();

        $comanda = $consulta->fetchObject(Comanda::class);
        if ($comanda){
            $comanda->asignarProductos($this->obtenerProductosPorComanda($comanda));
        }
        return $comanda;
    }

    private function actualizarComanda($comanda) {
        $query = Comanda::obtenerConsultaUpdate();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta = $comanda->bindearValoresUpdateEstado($consulta);

        $consulta->execute();
    }

    public function obtenerComandaPorId($id): Comanda {
        $query = Comanda::obtenerConsultaSelectPorId();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":id", $id);
        $consulta->execute();

        return $consulta->fetchObject(Comanda::class);
    }

    public function leerComandas() {
        $query = Comanda::obtenerConsultaSelect();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();

        return $consulta->fetchAll(Comanda::class);
    }

    public function leerComandaPorId($id) {
        $query = Comanda::obtenerConsultaSelectPorId();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":id", $id);

        $consulta->execute();
        return $consulta->fetchObject(Comanda::class);
    }

    public function obtenerComandasPorEstadoYTipoUsuario($tipoUsuario, $estado) {
        $query = "SELECT distinct c.id, c.* FROM Comanda c join comandaProducto cp on cp.comandaId = c.id join producto p on p.id = cp.productoId where p.tipoUsuarioPreparacionId = :tipoUsuario and c.estadoComanda = :estadoComanda";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->bindValue(":tipoUsuario", $tipoUsuario->value);
        $consulta->bindValue(":estadoComanda", $estado);

        $consulta->execute();
        $comandas = $consulta->fetchAll(PDO::FETCH_CLASS, Comanda::class);
        foreach($comandas as $comanda) {
            $productos = $this->obtenerProductosPorComanda($comanda);
            $comanda->asignarProductos($productos);
        }
        return $comandas;
    }

} 