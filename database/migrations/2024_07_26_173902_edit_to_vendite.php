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
        Schema::table('vendite', function (Blueprint $table) {
            $table->string('nazione_acquirente', 2)->default('IT')->after('indirizzo_acquirente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendite', function (Blueprint $table) {
            //
        });
    }
};
