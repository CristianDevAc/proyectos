@extends('adminlte::auth.login')

@section('auth_header', 'Iniciar sesión')
@section('auth_body')

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="Correo electrónico">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" required placeholder="Contraseña">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
    </form>

@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </p>
@endsection
