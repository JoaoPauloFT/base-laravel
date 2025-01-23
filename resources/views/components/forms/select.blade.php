<div>
    <label for="{{ $field }}">{{ $name }}</label>
    <select id="{{ $field.$formId }}" name="{{ $field }}" data-placeholder="{{ $placeholder }}" class="input-form {{ $mask }} {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" {{ $customAttributes }}>
        @if($placeholder && $mask == 'search-select')
            <option></option>
        @endif
        @foreach($options as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
    @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
        <p class="messageError">{{ $errors->first($field) }}</p>
    @endif
</div>

    <script>
        function afterLoad{{ $field.$formId }}() {
            @if($mask == 'search-select')
                $('#{{ $field.$formId }}').select2({
                    dropdownParent: $('#{{ $idModal }}'),
                    allowClear: true
                });

                $('#{{ $field.$formId }}').val('{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}').trigger('change');

                @if($errors->has($field))
                $('#{{ $field.$formId }}').data('select2').$container.addClass('errorField');
                @endif

                $('.input-form').on('select2:select', function () {
                    $(this).data('select2').$container.removeClass('errorField');
                    $(this).parent().find('.messageError').remove();
                });
            @elseif($value)
                $('#{{ $field.$formId }}').val('{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}');
            @endif
        }

        @if($isTab)
            $('#{{ $idModal }}').on('shown.bs.modal', function () {
                afterLoad{{ $field.$formId }}();
            });
        @else
            window.addEventListener('load', function () {
                afterLoad{{ $field.$formId }}();
            });
        @endif
    </script>
