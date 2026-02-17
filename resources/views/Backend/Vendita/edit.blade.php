@extends('Backend._layout._main')
@section('toolbar')
@endsection

@section('content')
    @php($vecchio=$record->id)
    <div class="card">
        <div class="card-body">
            @include('Backend.Orologio.datiOrologio',['record'=>$orologio])
            @include('Backend._components.alertErrori')
            <form method="POST" action="{{action([$controller,'update'],[$orologio->id,$record->id??''])}}" onsubmit="return disableSubmitButton()">
                @csrf
                @method($record->id?'PATCH':'POST')
                @php($uid=null)
                <div class="separator separator-content mt-10 mb-6">
                    <h4 class="w-300px ">Dati Acquirente</h4>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'progressivo_vendita','classe'=>'intero','required' => true ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputTextData',['campo'=>'data_vendita','label' => 'Data' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputRadioH',['campo'=>'tipo_acquirente','testo'=>'Tipo cliente','required'=>true,'array'=>['privato'=>'Privato','azienda'=>'Azienda']])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'cognome_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'nome_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'codice_fiscale_acquirente', 'classe'=>'uppercase'])
                    </div>
                </div>
                <div class="row" id="dati-business" style="display: none;">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'denominazione_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'partita_iva_acquirente', 'classe'=>'uppercase'])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'telefono_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'email_acquirente', 'classe'=>'lowercase'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2',['campo'=>'nazione_acquirente','required' => true,'selected'=>\App\Models\Nazione::selected(old('nazione_acquirente',$record->nazione_acquirente))])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'indirizzo_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2',['campo'=>'citta_acquirente', 'selected'=>\App\Models\Comune::selected(old('citta_acquirente',$record->citta_acquirente)),'label' => 'Città Aquirente'])
                        @include('Backend._inputs_v.inputText',['campo'=>'citta_estera','valore'=>$record->citta_acquirente??'','label' => 'Città Acquirente'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'cap_acquirente', ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'prezzo_di_vendita', 'classe'=>'importo'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'numero_fattura_vendita', ])
                    </div>
                </div>
                @include('Backend._inputs.dropzoneAllegati')


                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <button class="btn btn-primary mt-3" type="submit"
                                id="submit">{{$vecchio?'Salva modifiche':'Crea '.\App\Models\Vendita::NOME_SINGOLARE}}</button>
                    </div>
                    @if($vecchio)
                        <div class="col-md-4 text-end">
                            @if($eliminabile===true)
                                <a class="btn btn-danger mt-3" id="elimina" href="{{action([$controller,'destroy'],[$orologio->id,$record->id])}}">Elimina</a>
                            @elseif(is_string($eliminabile))
                                <span data-bs-toggle="tooltip" title="{{$eliminabile}}">
                                    <a class="btn btn-danger mt-3 disabled" href="javascript:void(0)">Elimina</a>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>

            </form>
        </div>
    </div>
@endsection
@push('customScript')
    <script src="/assets_backend/js-miei/select2_it.js"></script>
    <script src="/assets_backend/js-miei/autoNumeric.min.js"></script>
    <script src="/assets_backend/js-miei/dropzone.js"></script>
    <script src="/assets_backend/js-miei/flatPicker_it.js"></script>

    <script>
        $(function () {
            eliminaHandler('Questa Vendita verrà eliminata definitivamente');
            $('.tipo_acquirente').click(function () {
                mostraNascondi($(this).val());
            });
            mostraNascondi($('.tipo_acquirente:checked').val());
            impostaCampiCitta($('#nazione_acquirente').val());

            $('#data_vendita').flatpickr({
                allowInput: true,
                locale: 'it',
                dateFormat: 'd/m/Y',
                //maxDate: "today",
                enableTime: false,
                confirmDate: true,

                onChange: function () {
                },
                onClose: function (selectedDates, dateStr, instance) {

                }
            });

            function mostraNascondi(tipoCliente) {
                $('#dati-business').toggle(tipoCliente === 'azienda');
                richiediCampo('denominazione_acquirente', tipoCliente === 'azienda');
                richiediCampo('nome_acquirente', tipoCliente !== 'azienda');
                richiediCampo('cognome_acquirente', tipoCliente !== 'azienda');

            }

            select2Citta('citta_acquirente', 'la città', 1, 'citta');
            select2Universale('nazione_acquirente', 'una nazione', 3,'nazione')
                .on('select2:select', function (e) {
                    impostaCampiCitta($(this).val())
                });
            autonumericImporto('importo');
            autonumericIntero('intero');
            function impostaCampiCitta(nazione) {
                if (nazione === 'IT' || nazione === '') {
                    $('#div_citta_estera').hide();
                    $('#div_citta_acquirente').show();
                } else {
                    $('#div_citta_estera').show();
                    $('#div_citta_acquirente').hide();
                }
            }

            const allegatoType = 'acquirente';
            const urlUploadAllegato = '{{action([\App\Http\Controllers\Backend\AllegatoController::class,'uploadAllegato'])}}';
            const urlDeleteAllegato = '{{ action([\App\Http\Controllers\Backend\AllegatoController::class,'deleteAllegato']) }}';
            const allegatiEsistenti =@json(\App\Models\AllegatoServizio::perBlade($uid,$record->orologio_id,'acquirente'));
            const recordId = {{$record->orologio_id}};
            const uid = '{{$uid}}';

            dropzoneHandler(urlUploadAllegato, urlDeleteAllegato, allegatiEsistenti, recordId, allegatoType, uid);

        });
    </script>
@endpush
