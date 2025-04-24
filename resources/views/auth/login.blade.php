@extends('auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('message.access_message_login'))

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Email field --}}
        <div class="group">
            <div class="fields-group">
                <div class="input-group">
                    <label>{{ __('message.username') }}</label>
                    <input type="text" name="username" class="form-control"
                        value="{{ old('username') }}" placeholder="{{ __('message.enter_the_username') }}" autofocus>
                </div>

                {{-- Password field --}}
                <div class="input-group">
                    <label>{{ __('message.password') }}</label>
                    <div class='input-password'>
                        <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('message.digit_password') }}">
                        <div id="btnTogglePassword">
                            <i class="ti ti-eye" id="togglePassword"></i>
                        </div>
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="field-group">
                {{-- Login field --}}
                <div class="footer">
                    <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span>{{ __('message.login') }}</span>
                        <i class="ti ti-login-2"></i>
                    </button>
                </div>
            </div>
        </div>

    </form>

@stop

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
    });
</script>
