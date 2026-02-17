<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ElencoNazioniTableSeeder::class);
        $this->call(ElencoProvinceTableSeeder::class);
        $this->call(ElencoComuniTableSeeder::class);


        $this->call(RuoliSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
