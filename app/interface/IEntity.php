<?php

interface IEntity {
    public function valoresInsert();
    public static function obtenerConsultaInsert();
    public static function obtenerConsultaSelect();
    public static function obtenerConsultaSelectPorId();
    public static function obtenerConsultaDeletePorId();
    public function obtenerNombreImagen();

} 