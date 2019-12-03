<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="content">
                    <center><img src="{{ asset('img/logo.png') }}" class="img-fluid"></center>
                    <table style="font-size: 10px; text-align: center;" width="100%" class="table table-sm">
                    	<thead>
                    		<tr>
                    			<td colspan="4" style="text-align: center;"><h3>Datos del Trabajador</h3></td>
                    		</tr>
                    		<tr>
                    			<th><strong>Codigo y Cedula:</strong></th>
                    			<th><strong>Nombres y Apellidos:</strong></th>
                    			<th><strong>Cargo:</strong></th>
                    			<th><strong>Fecha de Ingreso:</strong></th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<tr>
                    			<td>({{ $datostrab->id_trab }}) {{ $datostrab->nacionalidad }}-{{ $datostrab->cedula }}</td>
                    			<td>{{ $datostrab->nombre }} {{ $datostrab->apellidos }}</td>
                    			<td>{{ $datostrab->cargo }}</td>
                    			<td>{{ $datostrab->f_ingAdmPubl }}</td>
                    		</tr>
                    		<tr>
                    			<td><strong>Nomina:</strong></td>
                    			<td>{{ $datostrab->id_nomina }} {{ $datostrab->denominacion }} {{ $datostrab->condicion }}</td>
                    			<td><strong>Dependencia:</strong></td>
                    			<td>{{ $datostrab->iddepen }} {{ $datostrab->dependencia }} </td>
                    		</tr>
                    	</tbody>
                    </table> 
                    		@for ($i = 0; $i < count($encanominas); $i++)
                    		<table style="font-size: 10px; text-align: center;" width="100%" class="table table-sm">
	                    	<thead>
	                    		<tr style="height: 5px;">
	                    			<td colspan="4" style="text-align: center;"><h5>Nomina</h5></td>
	                    		</tr>
	                    		<tr>
                    			<th style="width: 25%">Descripción</th>
                    			<th style="width: 25%">Cargo</th>
                    			<th style="width: 25%">Denominación</th>
                    			<th style="width: 25%">Forma Pago</th>
                    			</tr>
	                    	</thead>
	                    	<tbody>
    						<tr>
                    			<td>{{ $encanominas[$i]['nomina'] }} {{ $encanominas[$i]['descripcion'] }}</td>
                    			<td>{{ $encanominas[$i]['cargo'] }}</td>
                    			<td>{{ $encanominas[$i]['denominacion'] }}</td>
                    			<td>{{ $encanominas[$i]['idforpago'] }}</td>
                    		</tr>
                    		</tbody>
                    		</table>
                    		<table style="font-size: 9px; text-align: center;" width="100%" class="table table-sm">
                    			<thead>
		                    		<tr>
		                    			<th style="width: 20%">Codigo</th>
		                    			<th style="width: 60%">Descripción</th>
		                    			<th style="width: 10%">Asignación</th>
		                    			<th style="width: 10%">Deducción</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
		                    	<?php
								$subtotal_a=0;
								$subtotal_d=0;
								?>
                    			@for ($j = 0; $j < count($detnominas); $j++)
                    			@if ( $encanominas[$i]['cod_docu'] == $detnominas[$j]['cod_docum'])
                    				<tr>
		                    			<td>{{$detnominas[$j]['cod_docum']}} {{ $detnominas[$j]['cod_concep'] }}</td>
		                    			<td>{{ $detnominas[$j]['descrip_corta'] }}</td>
		                    			<td style="text-align:right;">{{ number_format($detnominas[$j]['asignacion'], 2, ',', '.') }}</td>
		                    			<td style="text-align:right;">{{ number_format($detnominas[$j]['deduccion'], 2, ',', '.') }}</td>
	                    			</tr>
	                    		<?php
								$subtotal_a=$subtotal_a+($detnominas[$j]['asignacion']*1);
								$subtotal_d=$subtotal_d+($detnominas[$j]['deduccion']*1);
								?>
								@endif
								@endfor
								<?php
								$total=$subtotal_a-$subtotal_d;
								$letras=NumeroALetras\NumeroALetras::convertir($total, 'Bolivares');  
								?>
								</tbody>
								<tfoot>
						            <tr>
						            	<th></th>
						                <th style="text-align:right;">SubTotales</th>
						                <th style="text-align:right;">{{ number_format($subtotal_a, 2, ',', '.') }}</th>
						                <th style="text-align:right;">{{ number_format($subtotal_d, 2, ',', '.') }}</th>    
						            </tr>
						            <tr>
						                <th style="text-align:right;">Total</th>
						                <th colspan="2">{{ $letras }}</th>
						                <th style="text-align:right;">{{ number_format($total, 2, ',', '.') }}</th>    
						            </tr>
						     </tfoot>
                    		</table>
							@endfor
                   		
                    
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>