@extends('Backend._layout._main')
@section('toolbar')
    @if(!$record->vendita)
        <a class="btn btn-sm btn-primary fw-bold" data-targetZ="kt_modal" data-toggleZ="modal-ajax"
           href="{{action([\App\Http\Controllers\Backend\VenditaController::class,'create'],$record->id)}}">Vendita</a>
    @endif
    <div class="me-0">
        <button
                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary @if(\App\Http\HelperForMetronic::SIDEBAR) bg-body @endif"
                data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-end">
            <i class="bi bi-three-dots fs-3"></i>
        </button>
        <!--begin::Menu 3-->
        <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-250px py-3"
                data-kt-menu="true">
            <!--begin::Heading-->
            <div class="menu-item px-3">
                <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Azioni</div>
            </div>
            <!--end::Heading-->
            <div class="menu-item px-3">
                <a href="{{action([$controller,'edit'],$record->id)}}"
                   class="menu-link px-3 azione">Modifica Acquisto</a>
            </div>
            @if($record->vendita)
                <div class="menu-item px-3">
                    <a href="{{action([\App\Http\Controllers\Backend\VenditaController::class,'edit'],[$record->id,$record->vendita->id])}}"
                       class="menu-link px-3 azione">Modifica Vendita</a>
                </div>
            @endif
        </div>
        <!--end::Menu 3-->
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="separator separator-content mt-5 mb-6">
                <h4 class="w-300px ">Dati Orologio</h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'progressivo_acquisto'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'tipo_acquisto','valore' => $record->badgeTipoAcquisto()])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'marca',])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'modello',])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'referenza',])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'seriale',])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'numero_movimento',])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'garanzia',])
                </div>
            </div>
            <div class="row">
                @if($record->vendita)
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputShow',['campo'=>'vendita','label' => 'Progressivo Vendita','valore' => $record->vendita->progressivo_vendita])
                    </div>
                @endif
            </div>
            <div class="separator separator-content mt-10 mb-6">
                <h4 class="w-300px ">Dati Venditore</h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'data_acquisto','valore' => $record->data_acquisto?->format('d/m/Y')])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'tipo_venditore','valore'=>ucfirst($record->tipo_venditore)])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'cognome_venditore','label'=>'Cognome'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'nome_venditore','label'=>'Nome'])
                </div>

                @if($record->tipo_venditore=='azienda')
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputShow',['campo'=>'denominazione_venditore','label'=>'Denominazione'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputShow',['campo'=>'partita_iva_venditore','label'=>'Partita IVA'])
                    </div>
                @endif
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'codice_fiscale_venditore','label'=>'Codice Fiscale'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'telefono_venditore','label'=>'Telefono'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'email_venditore','label'=>'Email'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'nazione_venditore','valore' => $record->nazione_venditore?\App\Models\Nazione::find($record->nazione_venditore)?->langIT:''])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'indirizzo_venditore','label'=>'Indirizzo'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'citta_venditore','valore' => is_numeric($record->citta_venditore)?\App\Models\Comune::find($record->citta_venditore)?->comuneConTarga():$record->citta_venditore,'label' => 'Città Venditore'])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'cap_venditore','label'=>'Cap'])
                </div>
                @if($record->tipo_venditore=='privato')
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputShow',['campo'=>'tipo_documento','valore' => \App\Enums\TipiDocumentoEnum::tryFrom($record->tipo_documento)?->testo()])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputShow',['campo'=>'numero_documento',])
                    </div>
                @endif
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'prezzo_di_acquisto','valore' => $record->prezzo_di_acquisto?\App\importo($record->prezzo_di_acquisto):''])
                </div>
                <div class="col-md-6">
                    @include('Backend._inputs_v.inputShow',['campo'=>'numero_fattura_acquisto',])
                </div>
            </div>
            @include('Backend.Orologio.allegati',['allegati' => \App\Models\AllegatoServizio::where('orologio_id',$record->id)->where('tipo_allegato','venditore')->get()])
            @includeWhen($record->vendita,'Backend.Orologio.showVendita',['record'=>$record->vendita,'orologio' => $record])
        </div>
    </div>
@endsection
