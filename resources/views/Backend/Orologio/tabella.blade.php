<div class="table-responsive">
    <table class="table table-row-bordered" id="tabella-elenco">
        <thead>
        <tr class="fw-bolder fs-6 text-gray-800">
            <th class="">Acquisto</th>
            <th class="">Tipo</th>
            <th class="">Marca</th>
            <th class="">Modello</th>
            <th class="">Referenza</th>
            <th class="">Seriale</th>
            <th class="">Venduto</th>
            <th class="text-center">Vendita</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($records as $record)
            <tr class="">
                <td class="">{{$record->progressivo_acquisto}}</td>
                <td class="">{!! $record->badgeTipoAcquisto() !!}</td>
                <td class="">{{$record->marca}}</td>
                <td class="">{{$record->modello}}</td>
                <td class="">{{$record->referenza}}</td>
                <td class="">{{$record->seriale}}</td>
                <td class="">
                    @if($record->vendita)
                        <span class="badge badge-success">Venduto</span>
                    @else
                        <span class="badge badge-warning">In Carico</span>
                    @endif
                </td>
                <td class="text-center">{{$record->vendita?->progressivo_vendita}}</td>
                <td class="text-end text-nowrap">
                    @if(!$record->vendita)
                        <a data-targetZ="kt_modal" data-toggleZ="modal-ajax"
                           class="btn btn-sm btn-light btn-primary"
                           href="{{action([\App\Http\Controllers\Backend\VenditaController::class,'create'],$record->id)}}">Vendi</a>
                        @endif
                    <a data-targetZ="kt_modal" data-toggleZ="modal-ajax"
                       class="btn btn-sm btn-light btn-active-light-primary"
                       href="{{action([$controller,'show'],$record->id)}}">Vedi</a>
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
