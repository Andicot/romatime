<div class=" mb-6" id="div_{{$campo}}">
    <label class="fw-bold fs-6 @if($required??false) required @endif" for="{{$campo}}"
           id="label_{{$campo}}">{{$label??ucwords(str_replace('_',' ',$campo))}}</label>
    @if($tooltip??false)
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{$tooltip}}"
           aria-label="{{$tooltip}}"></i>
    @endif
    @php($selected=old($campo,$record->$campo))
    <div class="d-flex flex-wrap mt-2">
        @foreach($array as $key=>$value)
            <div class="form-check form-check-custom form-check-solid me-10 mb-2 ">
                <input class="form-check-input {{$campo}}" type="radio" value="{{$key}}" name="{{$campo}}"
                       id="{{$campo.$key}}" {{($required??false)?'required':''}} {{$selected==$key?'checked':''}}>
                <label class="form-check-label" style="color: inherit;" for="{{$campo.$key}}">{{$value}}</label>
            </div>
        @endforeach
    </div>
    @if($help??false)
        <div class="form-text">{!! $help !!}</div>
    @endif
    @includeWhen($include??false,$include??'')
    <div class="fv-plugins-message-container invalid-feedback">
        @error($campo)
        {{$message}}
        @enderror
    </div>
</div>
