<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/arroyave/AVAPP2-02.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
  
    <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.css">
 
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

 
</head>
<body>
    <div id="app">
        @if (Auth::check())
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @else
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        @endif    
            
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{-- <img src="{{ asset('/images/arroyave/logo_grande_5.png') }}" class="logo"  style="height: 80px"/> --}}
            {{ config('app.name', 'Laravel') }}
        </a>
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    @if (Auth::check())
                    

                    <ul class="navbar-nav mr-auto">
                    
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Casos') }}</a>   
                            <a class="nav-link" href="{{ route('configuracion') }}">{{ __('Configuración') }}</a> 

                        @if (Auth::user()->perfil != 3)
                            {{-- <a class="nav-link" href="{{ route('afiliados.index') }}">{{ __('Listado') }}</a>  
                            <a class="nav-link" href="{{ route('reportes') }}">{{ __('Resportes') }}</a> --}}
                        @endif
                        
                        @if(Auth::user()->perfil == 1 or Auth::user()->perfil == 14)  
                        
                        {{-- <a class="nav-link" href="{{ route('lidere.index') }}">{{ __('Lideres') }}</a>
                        <a class="nav-link" href="{{ route('usuarios.index') }}">{{ __('Activar Usuario') }}</a> --}}
                        @endif  

                        @if (Auth::user()->perfil == 3)
                        {{-- <a class="nav-link" href="{{ route('lidere.index') }}">{{ __('Lideres') }}</a>
                        <a class="nav-link" href="{{ route('reportes') }}">{{ __('Reportes') }}</a>
                        <a class="nav-link" href="{{ route('mapa.index') }}">{{ __('Mapas') }}</a> --}}
                        @endif

                      
                    </ul>    
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Auth::check())
                        <li class="nav-item">
                         </li>
                        @endif
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a>
                                </li>
                            @endif
                            @if (Auth::check())
                            @if (Route::has('register'))
                                <li class="nav-item">
                                 </li>
                            @endif
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
 
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Casos') }}</a>   
                                    <a class="dropdown-item" href="{{ route('configuracion') }}">
                                        {{ __('Configuración') }}</a> 
                                    <a class="dropdown-item" href="{{ route('usuarios.edit', ['usuario' => Auth::user()->id]) }}">
                                        {{ __('Actualizar Datos') }} </a> 
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }} </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
        @yield('js')
        @stack('scripts')
</body>
</html>
