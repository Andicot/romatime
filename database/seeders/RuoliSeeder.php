<?php

namespace Database\Seeders;

use App\Enums\RuoliOperatoreEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RuoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (RuoliOperatoreEnum::cases() as $ruolo) {
            Role::create(['name' => $ruolo->value]);
        }

        \Artisan::call('permission:cache-reset');

    }
}
