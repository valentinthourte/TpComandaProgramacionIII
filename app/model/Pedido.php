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

    public function __construct5($numeroPedido, $cliente, $fechaHoraInicioPreparacion, $codigoMesa, $estadoPedido) {
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
        // $this->estadoPedido = EstadoPedido::Pendiente;
    }
    
    public function valoresInsert() {
        return array(":fechaHoraFinPreparacion"=>$this->fechaHoraFinPreparacion,":numeroPedido"=>$this->numeroPedido, ":cliente"=>$this->cliente, ":fechaHoraInicioPreparacion"=>$this->fechaHoraInicioPreparacion, ":tiempoEstimadoPreparacion"=>$this->tiempoEstimadoPreparacion, ":codigoMesa"=>$this->codigoMesa, ":estadoPedido"=>$this->estadoPedido->value);
    }
    
    public static function obtenerConsultaInsert() {
        return "INSERT INTO Pedido(numeroPedido, cliente, fechaHoraInicioPreparacion, tiempoEstimadoPreparacion, codigoMesa, estadoPedido, fechaHoraFinPreparacion) VALUES (:numeroPedido,:cliente,:fechaHoraInicioPreparacion,:tiempoEstimadoPreparacion,:codigoMesa,:estadoPedido, :fechaHoraFinPreparacion)";
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

    public function validarCambioEstado($estadoPedido) {
        switch ($estadoPedido) {
            case EstadoPedido::Pendiente:
                throw new Exception("No se puede asignar estado Pendiente al pedido.");
            case EstadoPedido::EnPreparacion:
                if ($this->estadoPedido != EstadoPedido::Pendiente) {
                    throw new Exception("El pedido debe estar Pendiente para ponerlo en preparación.");
                }
                break;
            case EstadoPedido::ListoParaServir:
                if ($this->estadoPedido != EstadoPedido::EnPreparacion) {
                    throw new Exception("El pedido debe estar En Preparacion para designarlo Listo para servir.");
                }
                if (!$this->comandasEstanListas()) {
                    throw new Exception("El pedido no se puede servir: Las comandas no estan listas. ");
                }
                break;
            case EstadoPedido::Servido:
                if ($this->estadoPedido != EstadoPedido::EnPreparacion) {
                    throw new Exception("El pedido debe estar En Preparacion para designarlo Listo para servir.");
                }
                break;
            case EstadoPedido::Anulado:
            default:
                break;
        }
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

    public function toHTML(): string {
        $comandasHtml = "";
        foreach ($this->comandas as $comanda) {
            $comandasHtml .= $comanda->toHTML();
        }

        return "
        <p>- Número de Pedido: {$this->numeroPedido}</p>
        <p>- Cliente: {$this->cliente}</p>
        <p>- Fecha y Hora de Inicio de Preparación: {$this->fechaHoraInicioPreparacion}</p>
        <p>- Tiempo Estimado de Preparación: {$this->tiempoEstimadoPreparacion}</p>
        <p>- Código de Mesa: {$this->codigoMesa}</p>
        <p>- Estado del Pedido: {$this->estadoPedido->value}</p>
        <p>- Comandas: </p>
        $comandasHtml
        <p>--------------------</p>
        ";
    }
}