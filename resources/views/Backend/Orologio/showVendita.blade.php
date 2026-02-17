<div class="separator separator-content mt-10 mb-6">
    <h4 class="w-300px ">Dati Acquirente</h4>
</div>
<div class="row">
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'data_vendita','valore' => $record->data_vendita->format('d/m/Y')])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'tipo_acquirente','valore' => ucfirst($record->tipo_acquirente)])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'cognome_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'nome_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'codice_fiscale_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'denominazione_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'partita_iva_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'telefono_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'email_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'nazione_acquirente','valore' => $record->nazione_acquirente?\App\Models\Nazione::find($record->nazione_acquirente)?->langIT:''])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'indirizzo_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'citta_acquirente','valore' => is_numeric($record->citta_acquirente)?\App\Models\Comune::find($record->citta_acquirente)?->comuneConTarga():$record->citta_acquirente,'label' => 'Città Acquirente'])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'cap_acquirente',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'prezzo_di_vendita','valore' => $record->prezzo_di_vendita?\App\importo($record->prezzo_di_vendita):''])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'numero_fattura_vendita',])
    </div>
    <div class="col-md-6">
        @include('Backend._inputs_v.inputShow',['campo'=>'utile','valore' => $orologio->utile?\App\importo($orologio->utile):''])
    </div>
</div>
@include('Backend.Orologio.allegati',['allegati' => \App\Models\AllegatoServizio::where('orologio_id',$record->orologio_id)->where('tipo_allegato','acquirente')->get()])
