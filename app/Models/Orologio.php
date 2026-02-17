<?php

namespace App\Models;

use App\Enums\RuoliOperatoreEnum;
use App\Enums\TipiAcquistoEnum;
use App\Traits\ThumbnailGenerationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Orologio extends Model
{
    use HasFactory;

    protected $table = "orologi";

    public const NOME_SINGOLARE = "orologio";
    public const NOME_PLURALE = "orologi";

    protected $casts = [
        'data_acquisto' => 'date'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELAZIONI
    |--------------------------------------------------------------------------
    */

    public function cittaVenditore()
    {
        return $this->hasOne(Comune::class,'id','citta_venditore');
    }

    public function nazioneVenditore()
    {
        return $this->hasOne(Nazione::class,'alpha2','nazione_venditore');
    }


    public function vendita(): HasOne
    {
        return $this->hasOne(Vendita::class, 'orologio_id');
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

    public function badgeTipoAcquisto()
    {
        $stato = TipiAcquistoEnum::tryFrom($this->tipo_acquisto);
        return '<span class="badge badge-' . $stato->colore() . ' fw-bolder me-2">' . $stato->testo() . '</span>';
    }

    /*
    |--------------------------------------------------------------------------
    | ALTRO
    |--------------------------------------------------------------------------
    */

    public function sincronizzaDati()
    {
        $testoRicerca = [];
        $testoRicerca[] = $this->denominazione_venditore;
        $testoRicerca[] = $this->seriale;
        $testoRicerca[] = $this->modello;
        $testoRicerca[] = $this->numero_fattura_acquisto;
        $testoRicerca[] = $this->referenza;
        if ($this->vendita) {
            $testoRicerca[] = $this->vendita->denominazione_acquirente;
            $this->utile = $this->vendita->prezzo_di_vendita - $this->prezzo_di_acquisto;
            $this->data_vendita = $this->vendita->data_vendita;
            $this->prezzo_di_vendita = $this->vendita->prezzo_di_vendita;
        } else {
            $this->utile = null;
            $this->data_vendita = null;
            $this->prezzo_di_vendita = null;
        }
        $this->testo_ricerca = implode("|", $testoRicerca);
        $this->save();
    }


}
