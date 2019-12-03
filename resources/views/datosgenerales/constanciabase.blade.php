<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Recibos de Pago</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
  
</head>
<body>
<div class="content">
<center>
	<br>
	<img src="{{ asset('img/logo.png') }}" class="img-fluid">
	<br>
	<h3>CONSTANCIA DE TRABAJO</h3>
</center>
<p>Quien Suscribe; LCDA. ZULIMAR COLMENAREZ, Director(a) de Recursos Humanos de
la Direccion Estadal de Salud de Portuguesa, por medio de la Presente hace
constar que el (la) Ciudadano(a): {{ $dato->nombre }} {{ $dato->apellidos }} Titular de
la Cedula de Identidad N°: {{ $dato->nacionalidad }}-{{ $dato->cedula }}, Presta sus servicios como: {{ $dato->descripcion }}, en calidad de {{ $dato->denominacion }} {{ $dato->condicion }}, con fecha de
ingreso {{ $dato->f_ingAdmPubl }}, cumpliendo funciones en: {{ $dato->dependencia }}  adcrito a esta Institucion, devengando un Sueldo Mensual de: {{ $dato->sueldo }} Bs.
</p>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#TblDatos').DataTable();
    } );
</script>
</body>
</html>