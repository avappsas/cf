<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo_CuentaFacil/icon_only/color_with_background.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.css">
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js" integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    {{-- <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script> --}} 
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
  {{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
  {{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.css"> --}}
  
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.js"></script> --}}

    
</head>
<body>
    <div id="app">
            
        @if (Auth::check())
            {{-- <div class="tab-bar" >
                
                <a class="brandF" href="{{ url('/home') }}">
                    <img src="{{ asset('/images/logo_CuentaFacil/png/color_transparent2.png') }}" class="logo"  style="height: 30px"/>
                </a>
                <a class="tab" onclick="window.location.href='{{ route('contratos.index') }}'" data-text="Mis Contrato">
                <span class="icon"><img src="{{ asset('/images/logo_CuentaFacil/png/icon/documento.png') }}" alt=""></span>
                </a>
                <a class="tab"  onclick="window.location.href='{{ route('juridica') }}'" data-text="Juridica">
                <span class="icon"><img src="{{ asset('/images/logo_CuentaFacil/png/icon/juridica.png') }}" alt=""></span>
                </a>
                <a class="tab" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"href="{{ route('cerrarSeccion') }}" data-text="Salir">
                <span class="icon"><img src="{{ asset('/images/logo_CuentaFacil/png/icon/cerrar-sesion.png') }}" alt=""></span>
                </a>
                @endif
                

                <form id="logout-form" action="{{ route('cerrarSeccion') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div> --}}
            

            
            <div class="tab-bar">
                <a class="brandF" href="{{ url('/home') }}">
                    <img src="{{ asset('/images/logo_CuentaFacil/png/color_transparent2.png') }}" class="logo"  style="height: 30px"/>
                </a>
                
                @foreach ($menu as $item)
                    <a class="tab" onclick="window.location.href='{{ route($item->ruta) }}'" data-text="{{ $item->Menu }}">
                        <span class="icon"><img src="{{ asset('/images/logo_CuentaFacil/png/icon/' . $item->icon) }}" alt=""></span>
                    </a>
                @endforeach

                <!-- Enlace de salir siempre visible -->
                <a class="tab" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="{{ route('cerrarSeccion') }}" data-text="Salir">
                    <span class="icon"><img src="{{ asset('/images/logo_CuentaFacil/png/icon/cerrar-sesion.png') }}" alt=""></span>
                </a>
            </div>
        @endif

        <!-- Formulario de cierre de sesión -->
        <form id="logout-form" action="{{ route('cerrarSeccion') }}" method="POST" class="d-none">
            @csrf
        </form>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer style="text-align: center;">
        {{-- <div id="copyright">Copyright&copy; 2023 - Página creada por Avapp - Todos los derechos reservados</div> --}}
    </footer>
        @yield('js')
</body>
</html>
