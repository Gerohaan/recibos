<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title>Recibos de Pago</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://getbootstrap.com/docs/4.3/examples/pricing/pricing.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
       <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    </head>
    <body>
  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">Sistema de Autogestón de RRHH</h5>
  <nav class="my-2 my-md-0 mr-md-3">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
        <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
  </nav>
  <a class="btn btn-outline-primary" href="#">Ingresar</a>
</div>
<center><img src="{{ asset('img/logo.png') }}" class="img-fluid"></center>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">Recibo de Pago</h1>
  <p class="lead">Aplicación para la gestión de trabajadores de la Dirección Estadal de Salud Portuguesa.</p>
</div>

<div class="container">
  <div class="card-deck mb-12 text-center">
    <div class="card mb-12 shadow-sm">
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Ingresa los datos del Trabajador</h4>
      </div>
      <div class="card-body">
        @include('flash::message')
         {!! Form::open(['route' => 'datos.query', 'method' => 'POST']) !!}
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!! Form::label('Cedula', 'Cedula') !!}
                    {!! Form::text('Cedula', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    {!! Form::label('Mes', 'Mes de Ingreso') !!}
                    {!! Form::select('Mes', array('' => 'Seleccione','01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'), null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    {!! Form::label('Anno', 'Año de Ingreso') !!}
                    {!! Form::text('Anno', null, ['class' => 'form-control']) !!}
                </div>
            </div>   
        </div>
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">Periodo a Consultar</h4>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    {!! Form::label('MesConsulta', 'Mes') !!}
                    {!! Form::select('MesConsulta', array('' => 'Seleccione','ENE' => 'Enero', 'FEB' => 'Febrero', 'MAR' => 'Marzo', 'ABR' => 'Abril', 'MAY' => 'Mayo', 'JUN' => 'Junio', 'JUL' => 'Julio', 'AGO' => 'Agosto', 'SEP' => 'Septiembre', 'OCT' => 'Octubre', 'NOV' => 'Noviembre', 'DIC' => 'Diciembre'), null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    {!! Form::label('AnnoConsulta', 'Año') !!}
                    {!! Form::text('AnnoConsulta', null, ['class' => 'form-control']) !!}
                </div>
            </div>   
        </div>                   
            {!! Form::submit('Buscar',['class' => 'btn btn-lg btn-block btn-outline-primary']) !!}
        
        {!! Form::close() !!}

      </div>
    </div>
    
  <footer class="pt-4 my-md-5 pt-md-5 border-top">
    <div class="row">
      <div class="col-12 col-md">
        <small class="d-block mb-3 text-muted">&copy; 2019 Diseño y Programación: Ing. Pedro Miguel Delgado</small>
      </div>
      <div class="col-6 col-md">
        <h5>Caracteristicas</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Flexibilidad</a></li>
          <li><a class="text-muted" href="#">Entorno Amigable</a></li>
          <li><a class="text-muted" href="#">Facilidad</a></li>
          <li><a class="text-muted" href="#">Mejora de Atención</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Opciones</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Perfil del trabajador</a></li>
          <li><a class="text-muted" href="#">Constancia de Trabajo</a></li>
          <li><a class="text-muted" href="#">Recibos de Pago</a></li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Nosotros</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="#">Equipo</a></li>
          <li><a class="text-muted" href="#">Ubicación</a></li>
          <li><a class="text-muted" href="#">Privacidad</a></li>
          <li><a class="text-muted" href="#">Terminos</a></li>
        </ul>
      </div>
    </div>
  </footer>
</div>
    </body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
</html>
