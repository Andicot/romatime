<div class=" mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6" for="{{$campo}}"
           id="label_{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    <span id="{{$campo}}" class="form-control {{$classe??''}}"
          style="min-height: 42px;"
            {!! $altro??'' !!}
        >{!! $valore??$record->$campo !!}</span>
    @if($help??false)
        <div class="form-text">{{$help}}</div>
    @endif
</div>

