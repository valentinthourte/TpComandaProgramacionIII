<?php


require_once("model/Encuesta.php");
require_once("services/MesaService.php");
require_once("services/PedidoService.php");

class EncuestaService extends AService {
    private PedidoService $pedidoService;
    private MesaService $mesaService;

    public function __construct() {
        parent::__construct();
        $this->pedidoService = new PedidoService();
        $this->mesaService = new MesaService();
    }

    public function leerEncuestas() {
        $query = Encuesta::obtenerConsultaSelect();
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, Encuesta::class);
    }

    public function crearEncuesta($parametros) {
        $encuesta = $this->validarParametrosYCrearEncuesta($parametros);

        $encuesta->asignarId($this->crearEntidad($encuesta));
        return $encuesta;
    }

    private function validarParametrosYCrearEncuesta($parametros) {
        $puntuacionMesa = $parametros["puntuacionMesa"];
        $puntuacionRestaurante = $parametros["puntuacionRestaurante"];
        $puntuacionMozo = $parametros["puntuacionMozo"];
        $puntuacionCocinero = $parametros["puntuacionCocinero"];
        $texto = $parametros["texto"];
        $experienciaEsBuena = $parametros["experienciaEsBuena"];
        $numeroPedido = $parametros["numeroPedido"];
        $numeroMesa = $parametros["numeroMesa"];

        
        $valido = ((isset($puntuacionMesa) && (int)$puntuacionMesa > 0 && $puntuacionMesa <= 10)  &&
                   (isset($puntuacionRestaurante) && (int)$puntuacionRestaurante > 0 && $puntuacionRestaurante <= 10) &&
                   (isset($puntuacionMozo) && (int)$puntuacionMozo > 0 && $puntuacionMozo <= 10) &&
                   (isset($puntuacionCocinero) && (int)$puntuacionCocinero > 0 && $puntuacionCocinero <= 10) &&
                   isset($texto) &&
                   (isset($experienciaEsBuena) && gettype($experienciaEsBuena) == "boolean") &&
                   isset($numeroPedido) &&
                   isset($numeroMesa));
        if ($valido == false) {
            throw new Exception("Los parametros enviados para la creacion de la encuesta no son validos. ");
        }
        $pedido = $this->pedidoService->obtenerPedidoPorNumero($numeroPedido);
        $mesa = $this->mesaService->leerMesaPorNumero($numeroMesa);

        if (!isset($mesa) || $mesa == false || $mesa->puedeRecibirComentarios() == false) {
            throw new Exception("La mesa no existe o no se encuentra cerrada. ");
        }

        if (!isset($pedido) || $pedido == false || $pedido->fueServido() == false) {
            throw new Exception("El pedido no existe o no se encuentra finalizado. ");
        }

        return new Encuesta($puntuacionMesa, $puntuacionRestaurante, $puntuacionMozo, $puntuacionCocinero, $texto, $experienciaEsBuena, $numeroPedido, $numeroMesa);
    }


    public function obtenerMejoresComentarios() {
        $query = Encuesta::obtenerConsultaSelect() . " WHERE experienciaEsBuena = 1";
        $consulta = $this->accesoDatos->prepararConsulta($query);
        $consulta->execute();
        $encuestas = $consulta->fetchAll(PDO::FETCH_CLASS, Encuesta::class);
        if ($encuestas == false || count($encuestas) == 0) {
            throw new Exception("No se encontraron encuestas positivas. ");
        }
        usort($encuestas, array('Encuesta', 'compararPuntuacionPromedio'));
        return $encuestas;
    
    }



}