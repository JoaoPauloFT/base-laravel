<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="changePasswordModal{{ $idItem }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal{{ $idItem }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="header">
                <div>
                    <h1>{{ __('message.edit_password') }}</h1>
                    <div>
                        <i class="ti ti-x" data-dismiss="modal"></i>
                    </div>
                </div>
                <p>{{ __('message.edit_description_password') }}</p>
            </div>

            <div class="body-modal">
                <form id="formSubmitChangePassword{{ $idItem }}" action="{{ $route }}" method="POST">
                    @csrf()
                    <input type="text" name="form" value="formSubmitChangePassword{{ $idItem }}" hidden>
                    @method('PUT')
                    <x-forms.field-password
                        generatePassword=true
                        formId="ChangePassword{{ $idItem }}"
                    />
                </form>
            </div>
            <div class="footer">
                <button type="button" class="secondary-button" data-dismiss="modal"> {{ __('message.cancel') }} </button>
                <button type="button" class="primary-button submit" onclick="$('#formSubmitChangePassword{{ $idItem }}').submit()">{{ __('message.edit') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        @if($errors->any() && old('form') == 'formSubmitChangePassword'.$idItem)
            document.getElementById('changePassword{{ $idItem }}').click();
        @endif

        $('.input-form').on('keypress', function () {
            $(this).removeClass('errorField');
            $(this).parent().find('.messageError').remove();
        });
    });
</script>
