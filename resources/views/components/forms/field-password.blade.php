<div>
    <label for="password">{{ __('message.password') }}</label>
    <div class="input-password {{ $generatePassword ? 'passwordField' : '' }}">
        <input id="password" name="password" type="password" placeholder="{{ __('message.digit_password') }}" class="input-form {{ $errors->has('password') && old('form') == 'formSubmit' ? 'errorField' : '' }}" value="{{ old('form') == 'formSubmit' ? old('password') : '' }}">
        <div id="btnTogglePassword">
            <i class="far fa-eye" id="togglePassword"></i>
        </div>
        @if($generatePassword)
            <button id="generatePassword" type="button" class="secondary-button">
                <i class="fa-solid fa-key"></i>
                <p>Gerar senha</p>
            </button>
        @endif
    </div>
    @if($errors->has('password') && old('form') == 'formSubmit')
        <p class="messageError">{{ $errors->first('password') }}</p>
    @endif
</div>

<script>
    window.addEventListener('load', function () {
        const btnTogglePassword = document.querySelector('#btnTogglePassword');

        btnTogglePassword.addEventListener('click', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

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
            $('#generatePassword').on('click', function () {
                $('#password').val(window.crypto.randomUUID().slice(0,8));
            });
        @endif
    });
</script>
