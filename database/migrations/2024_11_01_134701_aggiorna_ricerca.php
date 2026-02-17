<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\Orologio::get()->each(function (\App\Models\Orologio $record) {
            $testoRicerca = [];
            $testoRicerca[] = $record->denominazione_venditore;
            $testoRicerca[] = $record->seriale;
            $testoRicerca[] = $record->modello;
            $testoRicerca[] = $record->numero_fattura_acquisto;
            $testoRicerca[] = $record->referenza;
            $record->testo_ricerca = implode("|", $testoRicerca);
            $record->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
