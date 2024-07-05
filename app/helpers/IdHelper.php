<?php

class IdHelper {
    public static function generarNumeroAlfanumerico($tamaño) {
        $numeroPedido = "";
        $caracteres = "abcdefghijklmnopqrstuvwxyz0123456789";
        for($i = 0; $i < $tamaño; $i++) {
            $numeroPedido = $numeroPedido . substr(str_shuffle($caracteres), 0, 1);
        }
        return $numeroPedido;
    }
}