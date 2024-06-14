<?php

class ArrayHelper {



    public static function groupBy($items, $property) {
        $agrupados = array();
        foreach($items as $item) {
            $key = $item->$property;
                if (!array_key_exists($key, $agrupados)) {
                    $agrupados[$key] = array($item);
                }
                else {
                    $arreglo = $agrupados[$key];
                    array_push($arreglo, $item);
                    $agrupados[$key] = $arreglo;
                }
        }
        return $agrupados;
    }

    public static function encontrarMaximoPorPropiedad($lista, $propiedad) {
        $maxItem = $lista[0]; 
        foreach ($lista as $item) {
            if ($item->$propiedad > $maxItem->$propiedad) {
                $maxItem = $item;
            }
        }
        return $maxItem;
    }
}