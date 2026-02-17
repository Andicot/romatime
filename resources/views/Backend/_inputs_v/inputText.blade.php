<div class=" mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6 @if($required??false) required @endif" for="{{$campo}}"
           id="label_{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    @if($tooltip??false)
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{$tooltip}}"
           aria-label="{{$tooltip}}"></i>
    @endif

    <input type="text" id="{{$campo}}" name="{{$campo}}" class="form-control form-control-solid {{$classe??''}}"
           placeholder="{{$placeholder??''}}"
           value="{{ $odl??old($campo,isset($valore)===false?$record->$campo:$valore) }}"
           data-required="{{$required??''}}"
           @if($required??false) required @endif
           autocomplete="{{$autocomplete??''}}"
            {!! $altro??'' !!}
    >
    @if($help??false)
        <div class="form-text">{{$help}}</div>
    @endif
    @includeWhen($include??false,$include??'')
    <div class="fv-plugins-message-container invalid-feedback">
        @error($campo)
        {{$message}}
        @enderror
    </div>
</div>

