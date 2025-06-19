@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="logoLogin">
          <div></div>
          <div></div>
          <div></div>
          {{-- <svg viewBox="0 0 210 210">
            <path d="M103.7226715,142.5249634c7.0730667,1.6740265,14.5183868-1.3020172,21.9637146-8.7421417 	c10.4234619-10.4161987,18.2410431-20.4603577,23.6389008-29.7605286l-4.6533356-4.6500778 	c-5.5839844,7.6261444-13.9599762,16.9263077-25.1279678,28.0865097c-4.8394699,4.8360901-9.4927979,6.8821106-14.1461258,6.1381073 	s-10.981842-5.2080994-19.1717148-13.2062378l25.6863708-25.6684647c5.2117386-5.2080917,8.0037308-10.0441589,8.3759918-14.508255 	c0.372261-4.4640732-1.4890671-8.9281693-5.770134-13.2062454c-3.9088135-3.9060822-7.4453278-6.6961327-10.7957306-8.5561638 	c-3.3504028-1.8600349-6.3285141-2.9760628-8.9343948-3.3480644c-2.6058502-0.3720016-5.211731,0.1860123-8.1898422,1.4880295 	c-2.9781418,1.3020172-5.39785,2.9760666-7.6314697,4.6500854c-2.2335892,1.8600311-4.8394699,4.2780762-8.0037308,7.4401321 	c-4.8394699,4.8360901-8.375988,8.9281616-10.4234657,12.2762222c-2.0474739,3.3480682-3.350399,7.2541199-3.350399,11.5322037 	c-0.1861458,4.2780762,1.3029251,8.7421417,4.4671822,13.5782394s7.817585,10.4161987,14.3322411,16.9263153 	C87.5290985,134.3408356,96.6496048,140.8509521,103.7226715,142.5249634z M71.893898,105.3243103 	c-2.0474777-2.6040344-3.3504028-4.8360901-4.2810669-7.2541122c-0.9306641-2.2320328-1.3029251-4.2780838-1.3029251-5.9521027 	s0.372261-3.53405,1.4890671-5.5800934c1.1168137-2.046051,2.4197388-3.9060822,3.7226639-5.3940887 	c1.3029251-1.4880295,3.3504028-3.7200623,5.9562531-6.3240967c3.3504028-3.3480682,6.1424026-5.9521027,8.1898499-7.4401321 	c2.0474701-1.4880295,4.2810669-2.418045,6.700798-2.7900467c2.4197388-0.3720016,4.8394775,0.1860123,7.2591858,1.4880295 	c2.4197311,1.4880295,5.211731,3.9060822,8.5621338,7.2541199c2.4197311,2.418045,3.3503952,4.8360901,2.7919922,7.2541122 	c-0.558403,2.4180527-2.2335892,5.0220871-5.211731,7.9981461l-25.6863785,25.668457 	C76.547226,110.9044113,73.9413757,107.9283752,71.893898,105.3243103z"></path>
          </svg> --}}
          <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}" alt="logo" width="180px" height="180px" style="margin-left: 70px; margin-top: 50px;">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="box-shadow:0 0 20px -10px #000;">
                <div class="card-header">
                    <div class="float-right">                                    
                       {{ __('CuentaFacil') }} 
                       <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}" class="logo"  style="height: 25px"/>
                     </div>
                </div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Recuperar contraseña?') }}
                                    </a> --}}

                            {{-- <div class="col"> --}}
                                {{-- <a class="btn btn-link" href="{{ route('register') }}">{{ __('Registrarte') }}</a> --}}
                            {{-- </div> --}}
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <a class="btn btn-link" href="{{ route('asistencia-eventos.create') }}">{{ __('Registrarme al evento') }}</a> --}}
        </div>
    </div>
</div>
@endsection
