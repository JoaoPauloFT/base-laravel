<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="changePasswordModal{{ $idItem }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal{{ $idItem }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="header">
                <div>
                    <h1>{{ __('message.change_password') }}</h1>
                    <div>
                        <i class="ti ti-x" data-dismiss="modal" onclick="{{ $cancelAction }}"></i>
                    </div>
                </div>
            </div>

            <div class="body-modal">
                <form id="formChangePassword{{ $idItem }}" action="{{ $route }}" method="POST">
                    @csrf()
                    <input type="text" name="form" value="formChangePassword{{ $idItem }}" hidden>
                    @method('PUT')
                    <div>
                        <label for="password{{ $idItem }}">{{ __('message.password_new') }}</label>
                        <div class="input-password">
                            <input id="password{{ $idItem }}" name="password" type="password" placeholder="{{ __('message.digit_password') }}" class="input-form {{ $errors->has('password') && old('form') == 'formChangePassword'.$idItem ? 'errorField' : '' }}" value="{{ old('form') == 'formChangePassword'.$idItem ? old('password') : '' }}">
                            <div id="btnTogglePassword{{ $idItem }}">
                                <i class="ti ti-eye" id="togglePassword{{ $idItem }}"></i>
                            </div>
                            @if($generatePassword)
                                <button id="generatePassword{{ $idItem }}" type="button" class="secondary-button">
                                    <i class="ti ti-key"></i>
                                    <p class="mb-0">{{ __('message.generate_password') }}</p>
                                </button>
                            @endif
                        </div>
                        @if($errors->has('password') && old('form') == 'formChangePassword'.$idItem)
                            <p class="messageError">{{ $errors->first('password') }}</p>
                        @endif
                        <div class='condition-password'>
                            <p>{{ __('message.condition_password') }}</p>
                        </div>
                    </div>
                    <div>
                        <label for="password-confirmation{{ $idItem }}">{{ __('message.password_confirmation') }}</label>
                        <div class="input-password">
                            <input id="password-confirmation{{ $idItem }}" name="password_confirmation" type="password" placeholder="{{ __('message.digit_password') }}" class="input-form {{ $errors->has('password_confirmation') && old('form') == 'formChangePassword'.$idItem ? 'errorField' : '' }}" value="{{ old('form') == 'formChangePassword'.$idItem ? old('password_confirmation') : '' }}">
                            <div id="btnTogglePasswordConfirmation{{ $idItem }}">
                                <i class="ti ti-eye" id="togglePasswordConfirmation{{ $idItem }}"></i>
                            </div>
                        </div>
                        @if($errors->has('password_confirmation') && old('form') == 'formChangePassword'.$idItem)
                            <p class="messageError">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </div>
                </form>
            </div>
            <div class="footer">
                <button type="button" class="secondary-button" data-dismiss="modal" onclick="{{ $cancelAction }}"> {{ __('message.cancel') }} </button>
                <button type="button" class="primary-button submit" onclick="$('#formChangePassword{{ $idItem }}').submit()"><i class="ti ti-checks"></i>{{ __('message.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    function clean_modal_password(){
        $('#formChangePassword{{ $idItem }} input').each(function() {
            if ($(this).attr('type') !== 'hidden' && $(this).attr('name') !== 'form'){
                $(this).val('').trigger('change').click();
                $(this).removeClass("errorField"); //Remove a border-color do erro
            }
        });

        // Dispara um clique no select para limpar seu valor
        $('#formChangePassword{{ $idItem }} select').each(function() {
            $(this).val('').trigger('change').click();
            $('span.errorField').removeClass('errorField'); //Remove a border-color do erro
        });

        //Remove a mensagem do erro dos inputs
        $("#formChangePassword{{ $idItem }} p[class='messageError']").each(function(){
            $(this).remove();
        });
    }

    window.addEventListener('load', function () {

        const btnTogglePassword = document.querySelector('#btnTogglePassword{{ $idItem }}');

        btnTogglePassword.addEventListener('click', function () {
            const togglePassword = document.querySelector('#togglePassword{{ $idItem }}');
            const password = document.querySelector('#password{{ $idItem }}');

            if(password.getAttribute('type') === 'password') {
                password.setAttribute('type', 'text');
                togglePassword.classList.remove('ti-eye');
                togglePassword.classList.add('ti-eye-off');
            } else {
                password.setAttribute('type', 'password');
                togglePassword.classList.remove('ti-eye-off');
                togglePassword.classList.add('ti-eye');
            }
        });

        @if($generatePassword)
        $('#generatePassword{{ $idItem }}').on('click', function () {
            $('#password{{ $idItem }}').val(window.crypto.randomUUID().slice(0,8));
        });
        @endif

        const btnTogglePasswordConfirmation = document.querySelector('#btnTogglePasswordConfirmation{{ $idItem }}');

        btnTogglePasswordConfirmation.addEventListener('click', function () {
            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation{{ $idItem }}');
            const passwordConfirmation = document.querySelector('#password-confirmation{{ $idItem }}');

            if(passwordConfirmation.getAttribute('type') === 'password') {
                passwordConfirmation.setAttribute('type', 'text');
                togglePasswordConfirmation.classList.remove('ti-eye');
                togglePasswordConfirmation.classList.add('ti-eye-off');
            } else {
                passwordConfirmation.setAttribute('type', 'password');
                togglePasswordConfirmation.classList.remove('ti-eye-off');
                togglePasswordConfirmation.classList.add('ti-eye');
            }
        });


        @if($errors->any() && old('form') == 'formChangePassword'.$idItem)
            document.getElementById('changePassword{{ $idItem }}').click();

            $('#password{{ $idItem }}').on('keypress', function () {
                $(this).removeClass('errorField');

                let msg = $(this).parent().parent().find('.messageError');
                if (msg.length > 0) {
                    if (msg.attr('class').includes('subdesc'))
                        msg.removeClass('messageError').text('{{ __('message.format_text') }}');
                    else
                        msg.remove();
                }
            });

            $('#password-confirmation{{ $idItem }}').on('keypress', function () {
                $(this).removeClass('errorField');

                let msg = $(this).parent().parent().find('.messageError');
                if (msg.length > 0) {
                    if (msg.attr('class').includes('subdesc'))
                        msg.removeClass('messageError').text('{{ __('message.format_text') }}');
                    else
                        msg.remove();
                }
            });
        @endif
    });
</script>
