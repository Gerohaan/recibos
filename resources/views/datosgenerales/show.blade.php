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
                    <h3>Datos del Trabajador</h3>
                    </center>
                    <strong>Codigo y Cedula:</strong> ({{ $dato->id_trab }}) {{ $dato->nacionalidad }}-{{ $dato->cedula }}
					<br>
                    <strong>Nombres y Apellidos:</strong> {{ $dato->nombre }} {{ $dato->apellidos }}
					<br>
					<strong>Cargo:</strong> {{ $dato->descripcion }}
					<br>
					<strong>Fecha de Ingreso:</strong> {{ $dato->f_ingAdmPubl }} 
					<br>
                    <strong>Nomina:</strong> {{ $dato->id_nomina }} {{ $dato->denominacion }} {{ $dato->condicion }}
					<br>
					<strong>Dependencia:</strong> {{ $dato->iddepen }} {{ $dato->dependencia }} 
					<br>
                    <strong>Sueldo Base:</strong> {{ $dato->sueldo }} Bolivares
                    <br>
                    <strong>Periodo:</strong>
                    @if ($quincena->periodo=='3')
                        NOMINA MENSUAL {{ $periodo }} DESDE: {{ $quincena->desde }} HASTA: {{ $quincena->hasta }}
                    @elseif ($quincena->periodo=='2')
                        SEGUNDA QUINCENA {{ $periodo }} DESDE: {{ $quincena->desde }} HASTA: {{ $quincena->hasta }}
                    @else
                        PRIMERA QUINCENA {{ $periodo }} DESDE: {{ $quincena->desde }} HASTA: {{ $quincena->hasta }}
                    @endif
                    <br>
                    <center>
                    <h4>Detalle de Conceptos</h4>
                  
                  <table id="TblDato">
					<thead>
				        <tr>
				            <th style="width: 70%">Concepto</th>
				            <th style="width: 15%">Asignación</th>
				            <th style="width: 15%">Deducción</th>
				        </tr>
				    </thead>
				    <tbody> 
				    <?php
					$subtotal_a=0;
					$subtotal_d=0;
					?>
                    @forelse($detalles as $detalle)
					<tr style="padding: 3px; height: 30px;">
						<td style="text-align: justify;">
							{{ $detalle->cod_concep }} {{ $detalle->descripcion }}
						</td>
						<td style="text-align:right;">
							{{ number_format($detalle->total_a, 2, ',', '.') }}
						</td>
						<td style="text-align:right;">
							{{ number_format($detalle->total_d, 2, ',', '.') }}
						</td>
					</tr>
					<?php
					$subtotal_a=$subtotal_a+($detalle->total_a*1);
					$subtotal_d=$subtotal_d+($detalle->total_d*1);
					?>
					@empty

					@endforelse
					<?php
					$total=$subtotal_a-$subtotal_d;
					
					?>
					</tbody>
					<tfoot>
				            <tr>
				                <th style="text-align:right;">SubTotales</th>
				                <th style="text-align:right;">{{ number_format($subtotal_a, 2, ',', '.') }}</th>
				                <th style="text-align:right;">{{ number_format($subtotal_d, 2, ',', '.') }}</th>    
				            </tr>
				            <tr>
				                <th style="text-align:right;">Total</th>
				                <th style="text-align:right;"></th>
				                <th style="text-align:right;">{{ number_format($total, 2, ',', '.') }}</th>    
				            </tr>
				     </tfoot>
				</table>
                </center>
                <strong>Total Devengado:</strong> {{ $letras }}  
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
