<div class='d-flex flex-column'>
    <div class='row align-items-end'>
        <div class='col-md-6'>
            <label for="password">{{ __('message.password') }}</label>
            <div class='input-password'>
                <input id="password" name="password" type="password" placeholder="************" class="input-form {{ $errors->has('password') && old('form') == 'formSubmit' ? 'errorField' : '' }}" value="{{ old('form') == 'formSubmit' ? old('password') : '' }}">
                <div id="btnTogglePassword">
                    <i class="ti ti-eye" id="togglePassword"></i>
                </div>
            </div>
        </div>
        <div class='col-md-6 generate-password-button'>
            @if($generatePassword)
                <button id="generatePassword" type="button" class="secondary-button">
                    <i class="ti ti-key"></i>
                    <p>{{ __('message.generate') }}</p>
                </button>
            @endif
        </div>
    </div>
    <div class='d-flex flex-column'>
        @if($errors->has('password') && old('form') == 'formSubmit')
            <div>
                <p class="messageError">{{ $errors->first('password') }}</p>
            </div>
        @endif
        <div class='condition-password'>
            <p>{{ __('message.condition_password') }}</p>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        const btnTogglePassword = document.querySelector('#btnTogglePassword');

        btnTogglePassword.addEventListener('click', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

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
        function generatePassword(tamanho = 12) {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@$!%*?&#';
            let senha = '';
            const arrayAleatorio = new Uint8Array(tamanho);
            window.crypto.getRandomValues(arrayAleatorio);

            for (let i = 0; i < tamanho; i++) {
                senha += caracteres[arrayAleatorio[i] % caracteres.length];
            }

            // Garantir pelo menos uma letra maiúscula, uma minúscula e um caractere especial
            if (!/[A-Z]/.test(senha)) {
                senha = replaceRandomCharacter(senha, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
            }
            if (!/[a-z]/.test(senha)) {
                senha = replaceRandomCharacter(senha, 'abcdefghijklmnopqrstuvwxyz');
            }
            if (!/[0-9]/.test(senha)) {
                senha = replaceRandomCharacter(senha, '0123456789');
            }
            if (!/[@$!%*?&#]/.test(senha)) {
                senha = replaceRandomCharacter(senha, '@$!%*?&#');
            }

            return senha;
        }

        function replaceRandomCharacter(senha, caracteres) {
            const index = Math.floor(Math.random() * senha.length);
            const randomChar = caracteres[Math.floor(Math.random() * caracteres.length)];
            return senha.substring(0, index) + randomChar + senha.substring(index + 1);
        }

        $('#generatePassword').on('click', function () {
            $('#password').val(generatePassword(12));
        });
        @endif
    });
</script>
