<?php

enum TipoUsuario: int {
    case Mozo = 1;
    case Socio = 2;
    case Cervecero = 3;
    case Bartender = 4;
    case Cocinero = 5;
    case Pastelero = 6;
    case Cliente = 7;

    public function getNombre(): string {
        return match($this) {
            self::Mozo => 'mozo',
            self::Socio => 'socio',
            self::Cervecero => 'cervecero',
            self::Bartender => 'bartender',
            self::Cocinero => 'cocinero',
            self::Pastelero => 'pastelero',
            self::Cliente => 'cliente'
        };
    }
}