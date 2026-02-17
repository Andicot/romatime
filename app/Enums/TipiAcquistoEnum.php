<?php

namespace App\Enums;

enum TipiAcquistoEnum: string
{
    case acquisto = 'acquisto';
    case conto_vendita = 'conto_vendita';

    public function colore()
    {
        return match ($this) {
            self::acquisto => 'warning',
            self::conto_vendita => 'info',
        };
    }

    public function testo()
    {
        return match ($this) {
            self::acquisto => 'Acquisto',
            self::conto_vendita => 'Conto Vendita',
        };
    }
}
