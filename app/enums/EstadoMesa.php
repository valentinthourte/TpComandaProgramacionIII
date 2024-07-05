<?php

enum EstadoMesa: string {
    case ConClienteEsperandoPedido = "ConClienteEsperandoPedido";
    case ConClienteComiendo = "ConClienteComiendo";
    case ConClientePagando = "ConClientePagando";
    case Cerrada = "Cerrada";
    case Baja = "Baja";
}