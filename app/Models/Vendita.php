<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendita extends Model
{
    use HasFactory;

    protected $table = "vendite";

    public const NOME_SINGOLARE = "vendita";
    public const NOME_PLURALE = "vendite";


    protected $casts = [
        'data_vendita' => 'date'
    ];
    protected $fillable = [
        'orologio_id'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELAZIONI
    |--------------------------------------------------------------------------
    */
    public function cittaAcquirente()
    {
        return $this->hasOne(Comune::class,'id','citta_acquirente');
    }

    public function nazioneAcquirente()
    {
        return $this->hasOne(Nazione::class,'alpha2','nazione_acquirente');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | PER BLADE
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ALTRO
    |--------------------------------------------------------------------------
    */
}
