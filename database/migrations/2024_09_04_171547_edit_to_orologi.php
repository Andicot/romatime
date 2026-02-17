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
        Schema::table('orologi', function (Blueprint $table) {
            $table->string('nazione_venditore', 2)->default('IT')->after('email_venditore');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orologi', function (Blueprint $table) {
            //
        });
    }
};
