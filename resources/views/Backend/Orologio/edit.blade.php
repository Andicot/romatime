@extends('Backend._layout._main')
@section('toolbar')
@endsection

@section('content')
    @php($vecchio=$record->id)
    <div class="card">
        <div class="card-body">
            @include('Backend._components.alertErrori')
            <form method="POST" action="{{action([$controller,'update'],$record->id??'')}}" onsubmit="return disableSubmitButton()">
                @csrf
                @method($record->id?'PATCH':'POST')
                @php($uid=old('uid',$uid??null))
                <input type="hidden" name="uid" value="{{$uid}}">
                <div class="separator separator-content mt-5 mb-6">
                    <h4 class="w-300px ">Dati Orologio</h4>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputButtonEnum',['campo'=>'tipo_acquisto','required' => true,'cases' => \App\Enums\TipiAcquistoEnum::cases() ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'progressivo_acquisto','classe' => 'intero','required' => true ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2',['campo'=>'marca', 'required'=>true,'selected' => \App\Models\Marca::selected(old('marca',$record->marca)) ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'modello', 'required'=>true, ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'referenza', 'required'=>true, 'classe' => 'uppercase'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'seriale', 'required'=>true, 'classe' => 'uppercase' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'numero_movimento', 'required'=>false,'classe' => 'uppercase' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'garanzia', 'required'=>false, ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'prezzo_di_acquisto', 'classe'=>'importo'])
                    </div>
                </div>

                <div class="separator separator-content mt-10 mb-6">
                    <h4 class="w-300px ">Dati Venditore</h4>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputTextData',['campo'=>'data_acquisto','label' => 'Data' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputRadioH',['campo'=>'tipo_venditore','testo'=>'Tipo cliente','required'=>true,'array'=>['privato'=>'Privato','azienda'=>'Azienda']])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'cognome_venditore','label' => 'Cognome' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'nome_venditore','label' => 'Nome' ])
                    </div>

                </div>
                <div class="row" id="dati-business" style="display: none;">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'denominazione_venditore','label' => 'Denominazione' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'partita_iva_venditore', 'classe'=>'uppercase','label' => 'Partita Iva'])
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'codice_fiscale_venditore', 'classe'=>'uppercase','label' => 'Codice Fiscale'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'telefono_venditore', 'label' => 'Telefono'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'email_venditore', 'classe'=>'lowercase','label' => 'Email'])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2',['campo'=>'nazione_venditore','required' => true,'selected'=>\App\Models\Nazione::selected(old('nazione_venditore',$record->nazione_venditore))])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'indirizzo_venditore','label' => 'Indirizzo' ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2',['campo'=>'citta_venditore', 'selected'=>\App\Models\Comune::selected(old('citta_venditore',$record->citta_venditore)),'label' => 'Città'])
                        @include('Backend._inputs_v.inputText',['campo'=>'citta_estera','valore'=>$record->citta_acquirente??'','label' => 'Città Venditore'])

                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'cap_venditore', 'label' => 'Cap'])
                    </div>
                </div>
                <div class="row" id="dati-privato" style="display: none;">
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputSelect2Enum',['campo'=>'tipo_documento','cases' => \App\Enums\TipiDocumentoEnum::class ])
                    </div>
                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'numero_documento', 'classe'=>'uppercase'])
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        @include('Backend._inputs_v.inputText',['campo'=>'numero_fattura_acquisto', ])
                    </div>
                </div>
                @include('Backend._inputs.dropzoneAllegati')

                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <button class="btn btn-primary mt-3" type="submit"
                                id="submit">{{$vecchio?'Salva modifiche':'Crea '.\App\Models\Orologio::NOME_SINGOLARE}}</button>
                    </div>
                    @if($vecchio)
                        <div class="col-md-4 text-end">
                            @if($eliminabile===true)
                                <a class="btn btn-danger mt-3" id="elimina" href="{{action([$controller,'destroy'],$record->id)}}">Elimina</a>
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
            eliminaHandler('Questo Orologio verrà eliminato definitivamente');

            select2Universale('nazione_venditore', 'una nazione', 3,'nazione')
                .on('select2:select', function (e) {
                    impostaCampiCitta($(this).val())
                });

            impostaCampiCitta($('#nazione_venditore').val());
            function impostaCampiCitta(nazione) {
                if (nazione === 'IT' || nazione === '') {
                    $('#div_citta_estera').hide();
                    $('#div_citta_venditore').show();
                } else {
                    $('#div_citta_estera').show();
                    $('#div_citta_venditore').hide();
                }
            }



            $('#marca').select2({
                placeholder: 'Seleziona una marca',
                minimumInputLength: 1,
                allowClear: true,
                width: '100%',
                tags: true,
                // dropdownParent: $('#modalPosizione'),
                ajax: {
                    quietMillis: 150,
                    url: urlSelect2 + "?marca",
                    dataType: 'json',
                    data: function (term, page) {
                        return {
                            term: term.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
            $('#data_acquisto').flatpickr({
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


            $('.tipo_venditore').click(function () {
                mostraNascondi($(this).val());
            });
            mostraNascondi($('.tipo_venditore:checked').val());

            function mostraNascondi(tipoCliente) {
                $('#dati-business').toggle(tipoCliente === 'azienda');
                $('#dati-privato').toggle(tipoCliente !== 'azienda');
                richiediCampo('denominazione_venditore', tipoCliente === 'azienda');
                richiediCampo('nome_venditore', tipoCliente !== 'azienda');
                richiediCampo('cognome_venditore', tipoCliente !== 'azienda');


            }

            select2Citta('citta_venditore', 'la città', 1, 'citta');
            autonumericImporto('importo');
            autonumericIntero('intero');

            const allegatoType = 'venditore';
            const urlUploadAllegato = '{{action([\App\Http\Controllers\Backend\AllegatoController::class,'uploadAllegato'])}}';
            const urlDeleteAllegato = '{{ action([\App\Http\Controllers\Backend\AllegatoController::class,'deleteAllegato']) }}';
            const allegatiEsistenti =@json(\App\Models\AllegatoServizio::perBlade($uid,$record->id,'venditore'));
            const recordId = {{$record->id??'null'}};
            const uid = '{{$uid}}';

            dropzoneHandler(urlUploadAllegato, urlDeleteAllegato, allegatiEsistenti, recordId, allegatoType, uid);


        });
    </script>
@endpush
