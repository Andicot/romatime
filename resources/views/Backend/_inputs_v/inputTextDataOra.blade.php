<div class=" mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6 @if($required??false) required @endif" for="{{$campo}}"
           id="label_{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    @if($tooltip??false)
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{$tooltip}}"
           aria-label="{{$tooltip}}"></i>
    @endif
    <input type="text" id="{{$campo}}" name="{{$campo}}" class="form-control form-control-solid {{$classe??''}}"
           placeholder="{{$placeholder??''}}"
           value="{{ old($campo,$record->$campo?->format($format??'d/m/Y H:i')) }}" data-required="{{$required??''}}"
           @if($required??false) required @endif
           autocomplete="{{$autocomplete??''}}"
           data-inputmask="'mask': '{{$mask??'99/99/9999 99:99'}}'"
    >
    @if($help??false)
        <div class="form-text">{{$help}}</div>
    @endif
    <div class="fv-plugins-message-container invalid-feedback">
        @error($campo)
        {{$message}}
        @enderror
    </div>
</div>

