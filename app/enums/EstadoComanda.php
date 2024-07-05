<?php

enum EstadoComanda: string {
    
    case Anulado = "Anulado";
    case Pendiente = "Pendiente";
    case EnPreparacion = "EnPreparacion";
    case Preparada = "Preparada";
}