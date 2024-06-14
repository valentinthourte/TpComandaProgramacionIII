<?php

class ArrayHelper {



    public static function groupBy($items, $property) {
        $agrupados = array();

        foreach($items as $item) {
            $valorAgrupacion = ($item )->$property;
            if (!array_key_exists($valorAgrupacion, $agrupados)) {
                $agrupados[$valorAgrupacion] = array();
            }
            else {
                array_push($agrupados[$valorAgrupacion], $item);
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