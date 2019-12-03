<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Salud Portuguesa</title>

       <link rel="stylesheet" href="{{ asset('css/app.css') }}">
       

        
    </head>
    <body>
            
        <!-- Login  -->
        <!--  @include('datosgenerales.secciones.login') -->

        <!-- Encabezado -->
        @include('datosgenerales.secciones.header')

    
        <!-- Contenido inicio -->

                <div class="container">

                        @yield('contenido')
                    
                </div>

        <!-- Contenido fin -->
        
        <!-- Footer -->
        @include('datosgenerales.secciones.footer')

    </body>

    <script src="{{ asset('js/app.js') }}"></script>

</html>
