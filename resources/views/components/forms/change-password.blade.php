<link rel="stylesheet" href="{{ asset('css/modal.css') }}">
<div class="modal fade" id="changePasswordModal{{ $idItem }}" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal{{ $idItem }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="header">
                <div>
                    <h1>{{ __('message.edit_password') }}</h1>
                    <div>
                        <i class="fa-solid fa-x" data-dismiss="modal"></i>
                    </div>
                </div>
                <p>{{ __('message.edit_description_password') }}</p>
            </div>

            <div class="body-modal">
                <form id="formChangePassword{{ $idItem }}" action="{{ $route }}" method="POST">
                    @csrf()
                    <input type="text" name="form" value="formChangePassword{{ $idItem }}" hidden>
                    @method('PUT')
                    <div>
                        <label for="password">{{ __('message.password_new') }}</label>
                        <div class="input-password">
                            <input id="password{{ $idItem }}" name="password" type="password" placeholder="{{ __('message.digit_password') }}" class="input-form {{ $errors->has('password') && old('form') == 'formChangePassword'.$idItem ? 'errorField' : '' }}">
                            <div id="btnTogglePassword{{ $idItem }}">
                                <i class="far fa-eye" id="togglePassword{{ $idItem }}"></i>
                            </div>
                            @if($generatePassword)
                                <button id="generatePassword{{ $idItem }}" type="button" class="secondary-button">
                                    <i class="fa-solid fa-key"></i>
                                    <p>Gerar senha</p>
                                </button>
                            @endif
                        </div>
                        @if($errors->has('password') && old('form') == 'formChangePassword'.$idItem)
                            <p class="messageError subdesc">{{ $errors->first('password') }}</p>
                        @elseif ($restrictUserPassword)
                            <p class="subdesc">{{ __('message.format_text') }}</p>
                        @endif
                    </div>
                </form>
            </div>
            <div class="footer">
                <button type="button" class="secondary-button" data-dismiss="modal"> {{ __('message.cancel') }} </button>
                <button type="button" class="primary-button submit" onclick="$('#formChangePassword{{ $idItem }}').submit()">{{ __('message.edit') }}</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {

        @if($restrictUserPassword)
            document.querySelector("input#password{{ $idItem }}").addEventListener("input", function(){
                const allowedCharacters="0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN "; // You can add any other character in the same way

                this.value = this.value.split('').filter(char => allowedCharacters.includes(char)).join('')
            });
        @endif

        const btnTogglePassword{{ $idItem }} = document.querySelector('#btnTogglePassword{{ $idItem }}');

        btnTogglePassword{{ $idItem }}.addEventListener('click', function () {
            const togglePassword = document.querySelector('#togglePassword{{ $idItem }}');
            const password = document.querySelector('#password{{ $idItem }}');

            if(password.getAttribute('type') === 'password') {
                password.setAttribute('type', 'text');
                togglePassword.classList.remove('fa-eye');
                togglePassword.classList.add('fa-eye-slash');
            } else {
                password.setAttribute('type', 'password');
                togglePassword.classList.remove('fa-eye-slash');
                togglePassword.classList.add('fa-eye');
            }
        });

        @if($generatePassword)
        $('#generatePassword{{ $idItem }}').on('click', function () {
            $('#password{{ $idItem }}').val(window.crypto.randomUUID().slice(0,8));
        });
        @endif

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
        @endif
    });
</script>
