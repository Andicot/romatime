<?php

namespace App\Enums;

enum RuoliOperatoreEnum: string
{
    case admin = 'admin';

    public function colore()
    {
        return match ($this) {
            self::admin => 'info',
        };
    }

    public function testo()
    {
        return match ($this) {
            self::admin => 'Amministratore',
        };
    }
}
