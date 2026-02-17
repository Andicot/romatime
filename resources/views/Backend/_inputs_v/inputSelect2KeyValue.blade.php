<div class=" mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6 @if($required??false) required @endif"
           for="{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    @if($tooltip??false)
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
           data-bs-original-title="{{$tooltip}}" aria-label="{{$tooltip}}"></i>
    @endif

    @php($selected=old($campo,$record->$campo))
    <select id="{{$campo}}" name="{{$campo}}{{$multiple?'[]':''}}" class="form-select form-select-solid" @if($required??false) required
            @endif data-required="{{$required??''}}"
            data-kt-select2="true" data-placeholder="{{$placeholder??'Seleziona'}}"
            @if($multiple) multiple @endif
    @isset($altro)
        {!! $altro !!}
        @endisset
        {{-- data-minimum-results-for-search="Infinity" --}}

    >
        <option value="">{{$placeholder??'Seleziona'}}</option>
        @foreach($array as $key=>$value)
            <option value="{{$key}}" {{$selected==$key?'selected':''}}>{{$value}}</option>
        @endforeach

    </select>
    @if($help??false)
        <div class="form-text">{{$help}}</div>
    @endif
    <div class="fv-plugins-message-container invalid-feedback">
        @error($campo)
        {{$message}}
        @enderror
    </div>
</div>

