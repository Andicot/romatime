<div class="mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6 @if($required??false) required @endif" for="{{$campo}}"
           id="label_{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    @if($tooltip??false)
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title=""
           data-bs-original-title="{{$tooltip}}" aria-label="{{$tooltip}}"></i>
    @endif
    @php($multiple=$multiple??false)
    <div class=" fv-row fv-plugins-icon-container">
        <select id="{{$campo}}" name="{{$campo}}{{$multiple?'[]':''}}" class="form-select form-select-solid {{$classe??''}}"
                @if($required??false) required @endif data-required="{{$required??''}}"
                @if($multiple) multiple @endif
                @isset($url)
                    data-url="{{$url}}"
            @endisset
        @isset($altro)
            {!! $altro !!}
            @endisset
        >
            @if($selected)
                {!! $selected !!}
            @endif
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
</div>

