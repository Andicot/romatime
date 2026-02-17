<?php

namespace App\Enums;

enum TipiDocumentoEnum: string
{
    case carta_identita = 'carta_identita';
    case passaporto = 'passaporto';
    case patente = 'patente';




    public function testo()
    {
        return match ($this) {
            self::carta_identita => 'Carta Identità',
            self::passaporto => 'Passaporto',
            self::patente => 'Patente',

        };
    }
}
