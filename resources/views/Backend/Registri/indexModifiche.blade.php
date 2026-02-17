@extends('Backend._layout._main')
@section('titolo','Registro modifiche')
@section('content')
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{$titoloPagina}}</h1>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body pb-5 fs-6 px-2 px-md-6 ">
            <div class="table-responsive">
                @foreach($records as $record)
                    @php($colonnaDa=$record->event!='created')
                    <table id="tabella-storico" class="table table-bordered">
                        <thead>
                        <tr style="background-color: rgb(251,252,253);">
                            <td colspan="3"> {!! \App\Http\HelperForMetronic::iconaRegistro($record->event) !!} {{$record->created_at->format('d/m/Y H:i:s')}}
                                <strong>@lang('audits.event_'.$record->event) {{str_replace("App\Models\\",'',$record->auditable_type)}} {{$record->auditable_id}}</strong>
                                da {{$record->user?->nominativo() ?? ''}}
                                <span class="pull-right"><a href="javascript:void(0)" onclick="$('#storico_{{$loop->index}}').toggle();" title="Altre info"><i
                                            class="fa fa-info-circle"></i></a> </span>
                            </td>
                        </tr>
                        </thead>
                        <tbody id="contispesa-body">
                        <tr id="storico_{{$loop->index}}" style="display: none;">
                            <td colspan="3" style="font-size: smaller;">
                                url: {{$record->url}}<br>
                                ip: {{$record->ip_address}}<br>
                                agent: {{$record->user_agent}} <br>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Campo</strong></td>
                            @if($colonnaDa)
                                <td style="width: 40%;"><strong>Da</strong></td>
                            @endif
                            <td style="width: {{$colonnaDa?'40%;':'80%;'}}"><strong>A</strong></td>
                        </tr>
                        @foreach ($record->getModified() as $attribute => $modified)
                            @if(\App\Http\HelperForMetronic::visualizzaRigaAudit($modified))
                                <tr>
                                    <td class="campo text-right">
                                        {{$attribute}}
                                    </td>
                                    @if($colonnaDa)
                                        <td class="da">
                                            @if(array_key_exists('old',$modified))
                                                @if(!is_array($modified['old']))
                                                    {{$modified['old']===null?'<null>':$modified['old']}}
                                                @else
                                                    <div style="">
                                                        {{json_encode( $modified['old'])}}
                                                    </div>
                                                @endif
                                            @endif

                                        </td>
                                    @endif
                                    <td class="a">
                                        @isset($modified['new'])
                                            @if(!is_array($modified['new']))
                                                {{$modified['new']===null?'<null>':$modified['new']}}
                                            @else
                                                <div style="">
                                                    {{json_encode( $modified['new'])}}
                                                </div>
                                            @endif
                                        @endisset
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
            @if($records->lastPage()>1)
                <div class="row">
                    <div class="col-md-12 text-center">{{$records->links()}}</div>
                </div>
            @endif
        </div>
    </div>
@endsection
