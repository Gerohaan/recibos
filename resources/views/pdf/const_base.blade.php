<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<style>
    @page { margin: 180px 50px; }
    #header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; }
    #footer .page:after { content: counter(page, upper-roman); }
  </style>
</head>
<body>
<div id="header">
<center>
  <img src="{{ asset('img/logo.png') }}" class="img-fluid">
</center>
<p style="text-align: justify; size: 2px;">Rif: G-20008795-1</p>
<br>
</div>
<header><div class="content-wrapper">
<div id="content">
<h3 style="text-align: center;">CONSTANCIA DE TRABAJO</h3>
<br>
<br>
<div class="text-justify text-break">
<p>
Quien Suscribe; <strong>{{ $dato->jeferrhh }}</strong>, Director(a) de Recursos Humanos de la Dirección Estadal de Salud de Portuguesa, por medio de la Presente hace constar que el (la) Ciudadano(a): <strong>{{ $dato->apellidos }}, {{ $dato->nombre }}</strong> Titular de la Cedula de Identidad N°: <strong>{{ $dato->nacionalidad }}-{{ $dato->cedula }}</strong>, Presta sus servicios como: <strong>{{ $cargoconstancia }}</strong>, en calidad de <strong>{{ $nomina->denominacion }}</strong>, con fecha de ingreso <strong>{{ $fec_ing }}</strong>, cumpliendo funciones en: <strong>{{ $dato->dependencia }}</strong> adscrito  a esta Institución.
</p>
</div>
<br>
<div class="text-justify text-break">
<p>
Constancia que se expide de parte Interesada en la Ciudad de Guanare, a los {{ Carbon\Carbon::now()->format('d') }} dia(s) del mes de {{ Carbon\Carbon::now()->monthName }} del año {{ Carbon\Carbon::now()->format('Y') }}.
</p>	
</div>
<br>
<br>
<br>
<br>
		<div class="text-center">
        <strong>{{ $dato->jeferrhh }}</strong>
        </div>
        <div class="text-center">
          Director(a) de Recursos Humanos
        </div>
        <div class="text-center">
          Dirección  Estadal  de  Salud  de  Portuguesa
        </div>
</div>
<div id="footer">
	<div class="text-center">
		<pre style="font-size: 9px">
        <strong>"Vigilando la Salud de todos y todas"</strong>
        Dirección: Carrera 3 con calle 09, Antiguo Hospital sector Curazao Guanare - Portuguesa - Venezuela - 
        Teléfono: 0257-2512246 <a href="#">http://www.gestion-saludportuguesa.org.ve</a> - <a href="#">http://www.gestion-saludportuguesa.org.ve</a>
        </pre>
     </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>