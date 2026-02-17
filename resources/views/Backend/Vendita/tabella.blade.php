<div class="table-responsive">
    <table class="table table-row-bordered" id="tabella-elenco">
        <thead>
        <tr class="fw-bolder fs-6 text-gray-800">
<th class="">Orologio</th>
<th class="">Tipo Acquirente</th>
<th class="">Cognome Acquirente</th>
<th class="">Nome Acquirente</th>
<th class="">Codice Fiscale Acquirente</th>
<th class="">Denominazione Acquirente</th>
<th class="">Partita Iva Acquirente</th>
<th class="">Telefono Acquirente</th>
<th class="">Email Acquirente</th>
<th class="">Indirizzo Acquirente</th>
<th class="">Citta Acquirente</th>
<th class="">Cap Acquirente</th>
<th class="text-end">Prezzo Di Vendita</th>
<th class="">Numero Fattura Vendita</th>
<th class="">Utile</th>
        <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
            <tr class="" >
<td class="">
@if($record->orologio_id)
                        {{$record->orologio_id}}
                    @endif
                    </td>
<td class="">{{$record->tipo_acquirente}}</td>
<td class="">{{$record->cognome_acquirente}}</td>
<td class="">{{$record->nome_acquirente}}</td>
<td class="">{{$record->codice_fiscale_acquirente}}</td>
<td class="">{{$record->denominazione_acquirente}}</td>
<td class="">{{$record->partita_iva_acquirente}}</td>
<td class="">{{$record->telefono_acquirente}}</td>
<td class="">{{$record->email_acquirente}}</td>
<td class="">{{$record->indirizzo_acquirente}}</td>
<td class="">{{$record->citta_acquirente}}</td>
<td class="">{{$record->cap_acquirente}}</td>
<td class="text-end">{{\App\importo($record->prezzo_di_vendita)}}</td>
<td class="">{{$record->numero_fattura_vendita}}</td>
<td class="">{{$record->utile}}</td>

                <td class="text-end text-nowrap">
                    <a data-targetZ="kt_modal" data-toggleZ="modal-ajax"
                       class="btn btn-sm btn-light btn-active-light-primary"
                       href="{{action([$controller,'edit'],$record->id)}}">Modifica</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($records instanceof \Illuminate\Pagination\LengthAwarePaginator )
    <div class="w-100 text-center">
        {{$records->links()}}
    </div>
@endif
