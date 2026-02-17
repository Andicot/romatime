<?php

namespace Database\Factories;

use App\Models\Comune;
use Database\Seeders\CfPiRandom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendita>
 */
class VenditaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                 'orologio_id'=>,
     'tipo_acquirente'=>'',
     'cognome_acquirente'=>$this->faker->lastName,
     'nome_acquirente'=>$this->faker->firstName,
     'codice_fiscale_acquirente'=>CfPiRandom::getCodiceFiscale(),
     'denominazione_acquirente'=>$this->faker->company(),
     'partita_iva_acquirente'=>CfPiRandom::getPartitaIva(),
     'telefono_acquirente'=>$this->faker->phoneNumber(),
     'email_acquirente'=>$this->faker->unique()->safeEmail(),
     'indirizzo_acquirente'=>$this->faker->streetName(),
     'citta_acquirente'=>Comune::inRandomOrder()->first()->id,
     'cap_acquirente'=>rand(11111,55555),
     'prezzo_di_vendita'=>,
     'numero_fattura_vendita'=>'',
     'utile'=>'',

        ];
    }
}
