<?php

class Encuesta implements IEntity, JsonSerializable {
    private $id;
    private $puntuacionMesa;
    private $puntuacionRestaurante;
    private $puntuacionMozo;
    private $puntuacionCocinero;
    private $texto;
    private $experienciaEsBuena;
    private $numeroPedido;
    private $numeroMesa;

    function __construct()
	{
		$params = func_get_args();
        
		$num_params = func_num_args();
        
		$funcion_constructor ='__construct'.$num_params;
        
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}
    public function __construct8($puntuacionMesa, $puntuacionRestaurante, $puntuacionMozo, $puntuacionCocinero, $texto, $experienciaEsBuena, $numeroPedido, $numeroMesa) {
        $this->puntuacionMesa = $puntuacionMesa;
        $this->puntuacionRestaurante = $puntuacionRestaurante;
        $this->puntuacionMozo = $puntuacionMozo;
        $this->puntuacionCocinero = $puntuacionCocinero;
        $this->texto = $texto;
        $this->experienciaEsBuena = $experienciaEsBuena;
        $this->numeroPedido = $numeroPedido;
        $this->numeroMesa = $numeroMesa;
    }

    public function __construct9($id,$puntuacionMesa, $puntuacionRestaurante, $puntuacionMozo, $puntuacionCocinero, $texto, $experienciaEsBuena, $numeroPedido, $numeroMesa) {
        $this->id = $id;
        $this->puntuacionMesa = $puntuacionMesa;
        $this->puntuacionRestaurante = $puntuacionRestaurante;
        $this->puntuacionMozo = $puntuacionMozo;
        $this->puntuacionCocinero = $puntuacionCocinero;
        $this->texto = $texto;
        $this->experienciaEsBuena = $experienciaEsBuena;
        $this->numeroPedido = $numeroPedido;
        $this->numeroMesa = $numeroMesa;
    }

    public function asignarId($id) {
        $this->id = $id;
    }

    public static function compararPuntuacionPromedio(Encuesta $a, Encuesta $b) {
        return $b->puntuacionPromedio() <=> $a->puntuacionPromedio();
    }

    private function puntuacionPromedio() {
        return ((int)$this->puntuacionCocinero + (int)$this->puntuacionRestaurante + (int)$this->puntuacionMesa + (int)$this->puntuacionMozo) / 4;
    }

    public function valoresInsert() {
        return array(
            ":puntuacionMesa" => $this->puntuacionMesa,
            ":puntuacionRestaurante" => $this->puntuacionRestaurante,
            ":puntuacionMozo" => $this->puntuacionMozo,
            ":puntuacionCocinero" => $this->puntuacionCocinero,
            ":texto" => $this->texto,
            ":experienciaEsBuena" => $this->experienciaEsBuena,
            ":numeroPedido" => $this->numeroPedido,
            ":numeroMesa" => $this->numeroMesa
        );
    }
    public static function obtenerConsultaInsert() {
        return "INSERT INTO Encuesta(puntuacionMesa, puntuacionRestaurante, puntuacionMozo, puntuacionCocinero, texto, experienciaEsBuena, numeroPedido, numeroMesa) VALUES (:puntuacionMesa,:puntuacionRestaurante,:puntuacionMozo,:puntuacionCocinero,:texto,:experienciaEsBuena,:numeroPedido,:numeroMesa)";
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'puntuacionMesa' => $this->puntuacionMesa,
            'puntuacionRestaurante' => $this->puntuacionRestaurante,
            'puntuacionMozo' => $this->puntuacionMozo,
            'puntuacionCocinero' => $this->puntuacionCocinero,
            'texto' => $this->texto,
            'experienciaEsBuena' => $this->experienciaEsBuena,
            'numeroPedido' => $this->numeroPedido,
            'numeroMesa' => $this->numeroMesa
        ];
    }

    public static function obtenerConsultaSelect() {
        return "SELECT * FROM Encuesta";
    }
    public static function obtenerConsultaSelectPorId() {
        return Encuesta::obtenerConsultaSelect() . " WHERE id = :id";
    }
    public static function obtenerConsultaDeletePorId() {
        return "DELETE FROM Encuesta WHERE id = :id";
    }
    public function obtenerNombreImagen() {
        return "Encuesta_" . $this->numeroPedido . $this->numeroMesa;
    }
}