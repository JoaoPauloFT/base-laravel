<div class='d-flex flex-column'>
    <div class='row align-items-end'>
        <div class="{{ $colMd }}">
            <label for="{{ $field }}">{{ $name }}</label>
            <div class='input-password'>
                <input id="{{ $field.$formId }}" name="{{ $field }}" type="password" placeholder="{{ $placeholder }}" class="input-form field-passowrd {{ $errors->has($field) && old('form') == 'formSubmit'.$formId ? 'errorField' : '' }}" value="{{ old('form') == 'formSubmit'.$formId ? old($field) : '' }}" autocomplete="new-password">
                <div id="btnTogglePassword{{ $field.$formId }}">
                    <i class="ti ti-eye" id="togglePassword{{ $field.$formId }}"></i>
                </div>
            </div>
        </div>
        <div class='col-md-6 generate-password-button'>
            @if($generatePassword)
                <button id="generatePassword{{ $formId }}" type="button" class="secondary-button">
                    <i class="ti ti-key"></i>
                    <p>{{ __('message.generate') }}</p>
                </button>
            @endif
        </div>
    </div>
    <div class='d-flex flex-column'>
        @if($errors->has($field) && old('form') == 'formSubmit'.$formId)
            <div>
                <p class="messageError passwordError{{ $field }}">{{ ucfirst($errors->first($field)) }}</p>
            </div>
        @endif
        @if($conditionPassword)
            <div class='condition-password'>
                <p>{{ __('message.condition_password') }}</p>
            </div>
        @endif
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        const btnTogglePassword = document.querySelector('#btnTogglePassword{{ $field.$formId }}');

        btnTogglePassword.addEventListener('click', function () {
            const togglePassword = document.querySelector('#togglePassword{{ $field.$formId }}');
            const password = document.querySelector('#{{ $field.$formId }}');

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

        $('#generatePassword{{ $formId }}').on('click', function () {
            $('#password{{ $formId }}').val(generatePassword(12));
        });
        @endif
    });
</script>
