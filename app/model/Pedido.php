<?php 
require_once("model/Comanda.php");
require_once("model/Producto.php");
require_once("services/ComandaService.php");
require_once("helpers/ArrayHelper.php");
require_once("interface/IEntity.php");
require_once("enums/EstadoPedido.php");


class Pedido implements IEntity {
    public $numeroPedido; // como hago para mapear sin hacer todos los miembros publicos?
    public $comandas;
    public $cliente;
    public $fechaHoraInicioPreparacion;
    public $tiempoEstimadoPreparacion;
    public $codigoMesa;
    public $estadoPedido;
    public $fechaHoraFinPreparacion;
    public $rutaImagen;
    public $mozoId;
    
    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct4($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $codigoMesa) {
        $this->numeroPedido = $numeroPedido;
        $this->cliente = $cliente;
        $this->fechaHoraInicioPreparacion = $fechaHoraInicioPreparacion;
        $this->codigoMesa = $codigoMesa;
        $this->estadoPedido = EstadoPedido::Pendiente;
        $this->rutaImagen = null;
    }

    public function __construct5($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $codigoMesa, $mozoId) {
        $this->numeroPedido = $numeroPedido;
        $this->cliente = $cliente;
        $this->fechaHoraInicioPreparacion = $fechaHoraInicioPreparacion;
        $this->codigoMesa = $codigoMesa;
        
        $this->estadoPedido = EstadoPedido::Pendiente;
        $this->rutaImagen = null;
        $this->mozoId = $mozoId;
    }
    
    public function __construct6($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $codigoMesa, $mozoId, $estadoPedido) {
        $this->numeroPedido = $numeroPedido;
        $this->cliente = $cliente;
        $this->fechaHoraInicioPreparacion = $fechaHoraInicioPreparacion;
        $this->codigoMesa = $codigoMesa;
        $this->estadoPedido = match ($estadoPedido) {
            "Pendiente" => EstadoPedido::Pendiente,
            "EnPreparacion" => EstadoPedido::EnPreparacion,
            "ListoParaServir" => EstadoPedido::ListoParaServir
        };
        $this->rutaImagen = null;
        $this->mozoId = $mozoId;
    }


    public function obtenerFechaInicio() {
        return gettype($this->fechaHoraInicioPreparacion) == "string" ? DateTime::createFromFormat("Y-m-dH:i:s",str_replace(" ", "", $this->fechaHoraInicioPreparacion)) : $this->fechaHoraInicioPreparacion;
    }
    public function obtenerFechaFinPreparacion() {
        return gettype($this->fechaHoraFinPreparacion) == "string" ? DateTime::createFromFormat("Y-m-dH:i:s",str_replace(" ", "", $this->fechaHoraFinPreparacion)) : $this->fechaHoraFinPreparacion;
    }


    public function valoresInsert() {
        return array(":mozoId"=>$this->mozoId, ":fechaHoraFinPreparacion"=>$this->fechaHoraFinPreparacion,":numeroPedido"=>$this->numeroPedido, ":cliente"=>$this->cliente, ":fechaHoraInicioPreparacion"=>$this->fechaHoraInicioPreparacion, ":tiempoEstimadoPreparacion"=>$this->tiempoEstimadoPreparacion, ":codigoMesa"=>$this->codigoMesa, ":estadoPedido"=>$this->estadoPedido->value);
    }
    
    public static function obtenerConsultaInsert() {
        return "INSERT INTO Pedido(numeroPedido, cliente, fechaHoraInicioPreparacion, tiempoEstimadoPreparacion, codigoMesa, estadoPedido, fechaHoraFinPreparacion, mozoId) VALUES (:numeroPedido,:cliente,:fechaHoraInicioPreparacion,:tiempoEstimadoPreparacion,:codigoMesa,:estadoPedido, :fechaHoraFinPreparacion, :mozoId)";
    }

    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Pedido";
    }

    public static function obtenerConsultaSelectPorEstado() {
        return Pedido::obtenerConsultaSelect() . " WHERE estadoPedido = :estado";
    }

    public static function obtenerConsultaSelectPorId()
    {
        return Pedido::obtenerConsultaSelect() . " WHERE id = :id";
    }

    public static function obtenerConsultaDeletePorId() {
        return "DELETE FROM Pedido WHERE id = :id";
    }
    public static function obtenerConsultaUpdateEstado() {
        return "UPDATE Pedido SET estadoPedido = :estadoPedido, cliente = :cliente, fechaHoraFinPreparacion = :fechaHoraFinPreparacion where numeroPedido = :numeroPedido";
    }

    public function asignarImagen($ruta) {
        $this->rutaImagen = $ruta;
    }

    public function obtenerNombreImagen() {
        return "Pedido-" . $this->numeroPedido;
    }

    public function bindearValoresUpdateEstado($consulta) {
        $consulta->bindValue(":estadoPedido", $this->estadoPedido->value);
        $consulta->bindValue(":numeroPedido", $this->numeroPedido);
        $consulta->bindValue(":cliente", $this->cliente);
        $consulta->bindValue(":fechaHoraFinPreparacion", $this->fechaHoraFinPreparacion);

        return $consulta;
    }

    public static function obtenerConsultaUpdateImagen() {
        return "UPDATE Pedido SET rutaImagen = :rutaImagen where numeroPedido = :numeroPedido";
    }

    public function validarCambioEstado($estadoPedidoDestino) {
        $estadoPedido = $this->obtenerEstadoPedido();
        switch ($estadoPedidoDestino) {
            case EstadoPedido::Pendiente:
                throw new Exception("No se puede asignar estado Pendiente al pedido.");
            case EstadoPedido::EnPreparacion:
                if ($estadoPedido != EstadoPedido::Pendiente) {
                    throw new Exception("El pedido debe estar Pendiente para ponerlo en preparación.");
                }
                break;
            case EstadoPedido::ListoParaServir:
                if ($estadoPedido != EstadoPedido::EnPreparacion) {
                    throw new Exception("El pedido debe estar En Preparacion para designarlo Listo para servir.");
                }
                if (!$this->comandasEstanListas()) {
                    throw new Exception("El pedido no se puede servir: Las comandas no estan listas. ");
                }
                break;
            case EstadoPedido::Servido:
                if ($estadoPedido != EstadoPedido::ListoParaServir) {
                    throw new Exception("El pedido debe estar Listo para servir para Servirlo.");
                }
                break;
            case EstadoPedido::Anulado:
            default:
                break;
        }
    }

    public function obtenerTiempoEstimadoPreparacion() {
        $max = null;
        
        foreach ($this->comandas as $comanda) {
            if ($max === null || $comanda->tiempoPreparacionEstimado > $max) {
                $max = $comanda->tiempoPreparacionEstimado;
            }
        }
        return $max;
    }

    public function asignarComandas($comandas) {
        $this->comandas = $comandas;
    }

    public function comandasEstanListas() {
        return count(array_filter($this->comandas, function ($comanda) {
            return $comanda->estadoComanda != EstadoComanda::Preparada->value;
        })) == 0;
    }
    
    public function actualizarEstado(EstadoPedido $estadoPedido) {
        $this->estadoPedido = $estadoPedido;
        if ($estadoPedido == EstadoPedido::Servido) {
            $this->fechaHoraFinPreparacion = (new DateTime())->format('Y-m-d H:i:s');
        }
    }

    public function estaEnPreparacion() {
        return $this->obtenerEstadoPedido() == EstadoPedido::EnPreparacion;
    }

    public function fueServido() {
        return $this->obtenerEstadoPedido() == EstadoPedido::Servido;
    }
    private function obtenerEstadoPedido(): EstadoPedido {
        return gettype($this->estadoPedido) == "string" ? EstadoPedido::from($this->estadoPedido) : $this->estadoPedido;
    }

    public function toHTML(): string {
        $comandasHtml = "";
        foreach ($this->comandas as $comanda) {
            $comandasHtml .= $comanda->toHTML();
        }

        $imagenHtml = '';
        if (!empty($this->rutaImagen) && file_exists($this->rutaImagen)) {
            $imagenData = base64_encode(file_get_contents($this->rutaImagen));
            $imagenHtml = '<img src="data:image/jpeg;base64,' . $imagenData . '" alt="Imagen del Pedido" style="width: 200px; height: auto;"/>';
        }

        return "
        <p>- Número de Pedido: {$this->numeroPedido}</p>
        $imagenHtml
        <p>- Cliente: {$this->cliente}</p>
        <p>- Fecha y Hora de Inicio de Preparación: {$this->fechaHoraInicioPreparacion}</p>
        <p>- Tiempo Estimado de Preparación: {$this->tiempoEstimadoPreparacion}</p>
        <p>- Código de Mesa: {$this->codigoMesa}</p>
        <p>- Estado del Pedido: {$this->obtenerEstadoPedido()->value}</p>
        <p>- Comandas: </p>
        $comandasHtml
        <p>--------------------</p>
        ";
    }
}