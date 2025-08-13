@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="logoLogin">
            <div></div>
            <div></div>
            <div></div>
            <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}"
                 alt="logo" width="180" height="180"
                 style="margin-left: 70px; margin-top: 50px;">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="box-shadow:0 0 20px -10px #000;">
                <div class="card-header">
                    <div class="float-right">
                       {{ __('CuentaFacil') }}
                       <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}"
                            class="logo" style="height: 25px"/>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Campo Usuario (antes Correo) --}}
                        <div class="form-group row">
                            <label for="usuario" class="col-md-4 col-form-label text-md-right">
                                {{ __('Usuario') }}
                            </label>
                            <div class="col-md-6">
                                <input id="usuario"
                                       type="number"
                                       inputmode="numeric"
                                       class="form-control @error('usuario') is-invalid @enderror"
                                       name="usuario"
                                       value="{{ old('usuario') }}"
                                       placeholder="Ingresa tu número de cédula"
                                       required
                                       autocomplete="off"
                                       autofocus>
                                @error('usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Campo Contraseña --}}
                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right">
                                {{ __('Contraseña') }}
                            </label>
                            <div class="col-md-6">
                                <input id="password"
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Recordar --}}
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="remember"
                                           id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link"
                                       href="{{ route('password.request') }}">
                                        {{ __('Recuperar contraseña?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <a class="btn btn-link" href="{{ route('register') }}">
                {{ __('Crear usuario ') }}
            </a> --}}
        </div>
    </div>
</div>
@endsection
