<div class="d-flex flex-column">
    <label class="radio_title">{{ $name }}</label>
    <div class="radios">
        @foreach($options as $key => $option)
            <div>
                <input class="{{ $class }}" type="radio" id="{{  $field."_".$key.$formId  }}" name="{{ $field }}" value="{{ $key }}">
                <label for="{{ $field."_".$key.$formId }}">{{ __('message.'.$option) }}</label>
            </div>
        @endforeach
    </div>
</div>

<script>
    @if($onLoad)
        window.addEventListener('load', function(){
    @endif
        $('#{{ old('form') == 'formSubmit'.$formId ? $field."_".old($field).$formId : $field."_".$value.$formId }}').prop("checked", true);
    @if($onLoad)
        });
    @endif
</script>
