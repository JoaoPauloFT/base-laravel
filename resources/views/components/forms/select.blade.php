<div class="item-form-input">
    <label for="{{ $field.$formId }}">{{ $name }}</label>
    <select id="{{ $field.$formId }}" name="{{ $field }}" data-placeholder="{{ $placeholder }}" class="select-form {{ $mask }} {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" {{ $customAttributes }}>
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
                    @if($noSearch)
                        minimumResultsForSearch: -1,
                    @endif
                    @if($autoCompleteRoute)
                        ajax: {
                            url: '{{ route($autoCompleteRoute) }}',
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    q: params.term
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 0
                    @endif
                });
                @if($autoCompleteRoute)
                    let valorAtual = '{{ old("form") == "formSubmit" . $formId ? old($field) : $value }}';
                    if (valorAtual) {
                        $.ajax({
                            type: 'GET',
                            url: '{{ route($autoCompleteRoute) }}',
                            data: {
                                q: valorAtual,
                                selected: true // sinaliza que é valor selecionado
                            },
                            success: function(data) {
                                if (data && data.length > 0) {
                                    let option = new Option(data[0].text, data[0].id, true, true);
                                    if(data[0].id == 'new'){
                                        $('#{{ $field.$formId }}').append(option).trigger('change.select2');
                                    } else {
                                        $('#{{ $field.$formId }}').append(option).trigger('change');
                                    }
                                }
                            }
                        });
                    }
                @else
                    $('#{{ $field.$formId }}').val('{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}').trigger('change');
                @endif

                @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
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

        @if($onLoad)
            window.addEventListener('load', function () {
                afterLoad{{ $field.$formId }}();
            });
        @else
            $('#{{ $idModal }}').on('shown.bs.modal', function () {
                afterLoad{{ $field.$formId }}();
            });
        @endif
    </script>
