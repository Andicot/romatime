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
        Schema::create('orologi', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tipo_acquisto')->index();
            $table->string('marca');
            $table->string('modello');
            $table->string('referenza');
            $table->string('seriale');
            $table->string('numero_movimento')->nullable();
            $table->string('garanzia')->nullable();
            $table->string('testo_ricerca')->nullable()->index();

            $table->date('data_acquisto');
            //Dati venditore
            $table->unsignedInteger('progressivo_acquisto');
            $table->string('tipo_venditore')->index();
            $table->string('cognome_venditore')->nullable();
            $table->string('nome_venditore')->nullable();
            $table->string('codice_fiscale_venditore')->nullable();
            $table->string('denominazione_venditore')->nullable();
            $table->string('partita_iva_venditore')->nullable();
            $table->string('telefono_venditore')->nullable();
            $table->string('email_venditore')->nullable();
            $table->string('indirizzo_venditore')->nullable();
            $table->string('citta_venditore')->nullable();
            $table->string('cap_venditore')->nullable();
            $table->decimal('prezzo_di_acquisto')->nullable();
            $table->string('numero_fattura_acquisto')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->date('data_vendita')->nullable()->index();
            $table->decimal('prezzo_di_vendita')->nullable();
            $table->string('utile')->nullable();

        });

        Schema::create('vendite', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('orologio_id')->constrained('orologi')->cascadeOnDelete();
            $table->date('data_vendita');

            //Dati venditore
            $table->string('tipo_acquirente')->index();
            $table->string('cognome_acquirente')->nullable();
            $table->string('nome_acquirente')->nullable();
            $table->string('codice_fiscale_acquirente')->nullable();
            $table->string('denominazione_acquirente')->nullable();
            $table->string('partita_iva_acquirente')->nullable();
            $table->string('telefono_acquirente')->nullable();
            $table->string('email_acquirente')->nullable();
            $table->string('indirizzo_acquirente')->nullable();
            $table->string('citta_acquirente')->nullable();
            $table->string('cap_acquirente')->nullable();
            $table->decimal('prezzo_di_vendita')->nullable();
            $table->string('numero_fattura_vendita')->nullable();
            $table->unsignedInteger('progressivo_vendita');


        });

        Schema::create('allegati', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('uid')->nullable()->index();
            $table->string('filename_originale');
            $table->string('path_filename');
            $table->unsignedBigInteger('dimensione_file');
            $table->string('tipo_file');
            $table->string('thumbnail')->nullable();
            $table->foreignId('orologio_id')->nullable()->constrained('orologi');
            $table->string('tipo_allegato')->index();
        });


        Schema::create('marche', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome_marca')->index();
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
