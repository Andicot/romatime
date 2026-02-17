<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registro_login', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email');
            $table->ipAddress('ip');
            $table->string('dominio', 50)->nullable();
            $table->boolean('riuscito')->default(0);
            $table->boolean('remember')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('impersonato_da_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->text('user_agent')->nullable();
        });

        Schema::create('elenco_comuni', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('regione_id')->default(null);
            $table->unsignedBigInteger('provincia_id')->default(null);
            $table->string('comune')->default(null);
            $table->string('cap', 5)->nullable();
            $table->string('codice_catastale', 4)->default(null);
            $table->char('targa', 4)->default('');
            $table->boolean('soppresso')->default(0)->index();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
        });


        Schema::create('elenco_province', function (Blueprint $table) {
            $table->id();
            $table->string('provincia')->default(null);
            $table->string('sigla_automobilistica')->default(null);
            $table->unsignedBigInteger('id_regione')->default(null);
            $table->string('regione')->default(null);
        });

        Schema::create('elenco_nazioni', function (Blueprint $table) {
            $table->string('alpha2', 2)->primary();
            $table->string('alpha3', 3);
            $table->string('langEN', 45);
            $table->string('langIT', 45)->index();
            $table->string('nazionalitaEN', 45)->nullable();
            $table->string('nazionalitaIT', 50)->nullable()->index();
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
