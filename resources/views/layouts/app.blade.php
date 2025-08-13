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
    <script src="https://code.iconify.design/2/2.0.3/iconify.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js" integrity="sha512-7U4rRB8aGAHGVad3u2jiC7GA5/1YhQcQjxKeaVms/bT66i3LVBMRcBI9KwABNWnxOSwulkuSXxZLGuyfvo7V1A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> 
 
    
</head>
<body>
    <div id="app">
            
        @if (Auth::check()) 
            
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
                <a class="tab" href="{{ route('users.edit', Auth::user()->id) }}" data-text="Mi Usuario">
                    <img src="{{ asset('storage/' . (Auth::user()->foto ?? 'fotoPerfil/usuario2.png')) }}"
                        alt="Mi foto"
                        class="rounded-circle border border-success"
                        style="width: 35px; height: 35px; object-fit: cover;">
                </a>
 
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        @yield('js')
        @stack('scripts')
</body>
<script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>
</html>
