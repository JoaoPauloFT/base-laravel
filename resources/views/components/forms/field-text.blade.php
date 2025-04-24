<div class="item-form-input">
    <label for="{{ $field }}">{{ $name }}</label>
    <textarea id="{{ $field.$formId }}" name="{{ $field }}" placeholder="{{ $placeholder }}" maxlength="{{ $maxlength }}"class="input-form {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" rows="4" data-old-value="{{ $value }}" {{ $customAttributes }}>{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}</textarea>
    <div class="d-flex justify-content-between">
        <div>
            @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
                <p class="messageError">{{ $errors->first($field) }}</p>
            @endif
        </div>
        <div class="textarea-counter">
            <div id="counter{{ $field.$formId }}">
                0
            </div>
            <div>
                /{{ $maxlength }}
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function(){
        $("#counter{{ $field.$formId }}").text($('#{{ $field.$formId }}').val().length);
        $("#{{ $field.$formId }}").on("input change", function() {
            $("#counter{{ $field.$formId }}").text($(this).val().length);
        });
    });
</script>
