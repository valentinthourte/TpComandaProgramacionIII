<?php


enum EstadoPedido: string {
    case Anulado = "Anulado";
    case Pendiente = "Pendiente";
    case EnPreparacion = "EnPreparacion";
    case ListoParaServir = "ListoParaServir";
    case Servido = "Servido"; 
}