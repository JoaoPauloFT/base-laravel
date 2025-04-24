<div class="item-form-input">
    <label for="{{ $field.$formId }}">{{ $name }}</label>
    <input id="{{ $field.$formId }}" name="{{ $field }}" placeholder="{{ $placeholder }}" class="input-form {{ $mask }} {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" type="{{ $type }}" value="{{ old('form') == 'formSubmit'.$formId ? old($field) : $value }}" {{ $oldValue ? "data-old-value=$value" : "" }} {{ $customAttributes }} autocomplete=off {{ str_contains($mask, "time-picker") ? "data-toggle=datetimepicker data-target=#".$field.$formId : "" }}>
    @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
        <p class="messageError">{{ ucfirst($errors->first($field)) }}</p>
    @endif
</div>
<script>
    @if($onLoad)
        window.addEventListener('load', function(){
    @endif
        @if(str_contains($mask, "date-picker"))
            var dropOption = {{!! $customDate !!}}.drops ? 'up' : null;
            $('#{{ $field.$formId }}').daterangepicker({
                {!! $customDate !!}
                "drops": dropOption,
                "locale": {
                    "format": "MM/DD/YYYY",
                    "separator": " - ",
                    "applyLabel": "{{ __('message.apply') }}",
                    "cancelLabel": "{{ __('message.cancel') }}",
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": [
                        "{{ __('message.dom') }}",
                        "{{ __('message.seg') }}",
                        "{{ __('message.ter') }}",
                        "{{ __('message.qua') }}",
                        "{{ __('message.qui') }}",
                        "{{ __('message.sex') }}",
                        "{{ __('message.sab') }}",
                    ],
                    "monthNames": [
                        "{{ __('message.January') }}",
                        "{{ __('message.February') }}",
                        "{{ __('message.March') }}",
                        "{{ __('message.April') }}",
                        "{{ __('message.May') }}",
                        "{{ __('message.June') }}",
                        "{{ __('message.July') }}",
                        "{{ __('message.August') }}",
                        "{{ __('message.September') }}",
                        "{{ __('message.October') }}",
                        "{{ __('message.November') }}",
                        "{{ __('message.December') }}"
                    ],
                },
            }).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY'));
                $(this).removeClass('errorField');
                $(this).parent().find('.messageError').remove();
            });
        @elseif(str_contains($mask, "time-picker"))
            $('#{{ $field.$formId }}').datetimepicker({
                format: "LT",
                buttons: {
                    showClose: true
                },
            });
        @endif

        @if($type == "number")
            $("#{{ $field.$formId }}").on('keypress', function(evt){
                if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57){
                    evt.preventDefault();
                }
            });
        @endif
    @if($onLoad)
        });
    @endif
</script>
