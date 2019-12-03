<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<style>
    @page { margin: 20px 50px; }
    #footer { position: fixed; left: 0px; bottom: -50px; right: 0px; height: 100px; }
    #footer .page:after { content: counter(page, upper-roman); }
  </style>
</head>
<body>
<div class="content">
<div class="row">
<center>
<img src="{{ asset('img/logo.png') }}" class="img-fluid">
<h5>COMPROBANTE DE RETENCIONES</h5>
DEL IMPUESTO SOBRE LA RENTA DESDE EL {{ date('d/m/Y', strtotime($lapse['start'])) }} HASTA EL {{ date('d/m/Y', strtotime($lapse['end'])) }}
</center>
</div>
    <table style="font-size: 9px; text-align: justify;" width="100%" class="table table-sm">
    	<thead>
    		<tr>
    			<th colspan="4" style="text-align: center;">DATOS DEL AGENTE DE RETENCIÓN</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td colspan="3"><strong>NOMBRE DEL ORGANISMO:</strong> {{ $gerencials->nom_fis }}</td>
    			<td><strong>NÚMERO RIF:</strong> {{ $gerencials->rif_int }}</td>
    		</tr>
    		<tr>
    			<td colspan="3"><strong>FUNCIONARIO AUTORIZADO PARA HACER LA RETENCIÓN:</strong> {{ $gerencials->nom_admin }}</td>
    			<td><strong>NÚMERO RIF.</strong> {{ $gerencials->rif_admin }}</td>
    		</tr>
    		<tr>
    			<td colspan="3"><strong>DIRECCIÓN Y TELEFONO:</strong> {{ $gerencials->domic_fis }} {{ $gerencials->phone }}</td>
    			<td><strong>FECHA CIERRE</strong> {{ date('d/m/Y', strtotime($lapse['end'])) }}</td>
    		</tr>
    	</tbody>
    </table>
    <table style="font-size: 9px; text-align: justify;" width="100%" class="table table-sm">
    	<thead>
    		<tr>
    			<th colspan="4" style="text-align: center;">DATOS DEL BENEFICIARIO</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr>
    			<td colspan="3"><strong>APELLIDOS Y NOMBRES:</strong> {{ $datostrab->apellidos }} {{ $datostrab->nombre }}</td>
    			<td><strong>CEDULA DE IDENTIDAD:</strong> {{ $datostrab->nacionalidad }}-{{ $datostrab->cedula }}</td>
    		</tr>
    		<tr>
    			<td colspan="2"><strong>DEPENDENCIA:</strong> {{ $datostrab->dependencia }}</td>
    			<td colspan="2"><strong>DENOMINACIÓN:</strong> {{ $datostrab->denominacion }}</td>
    		</tr>
    		<tr>
    			<td colspan="2"><strong>CARGO:</strong> {{ $datostrab->cargo }}</td>
    			<td colspan="2"><strong>FORMA DE PAGO:</strong> {{ $datostrab->formap }}-{{ $datostrab->banco }}</td>
    		</tr>
    	</tbody>
    </table>
	<table style="font-size: 9px; text-align: center;" width="100%" class="table table-sm">
		<thead>
			<tr style="height: 5px;">
				<td colspan="6" style="text-align: center;"><h5>INFORMACION DEL IMPUESTO RETENIDO Y ENTERADO</h5></td>
			</tr>
	        <tr>
            	<th style="width: 25%">MES</th>
            	<th style="width: 15%">Remuneración Pagada</th>
            	<th style="width: 15%">Porc. de Retención</th>
            	<th style="width: 15%">Impuesto Retenido</th>
            	<th style="width: 15%">Remuneración + Impuesto Retenido</th>
            	<th style="width: 15%">Impuesto Retenido Acumulado</th>
            </tr>
	    </thead>
        @for ($i = 0; $i < count($arrayARI); $i++)
	    <tbody>
    		<tr>
        		<td>{{ $arrayARI[$i]['mes'] }}</td>
        		<td>{{ number_format($arrayARI[$i]['remuneracion'], 2, ',', '.') }}</td>
        		<td>{{ number_format($arrayARI[$i]['porcret'], 2, ',', '.') }}</td>
        		<td>{{ number_format($arrayARI[$i]['impret'], 2, ',', '.') }}</td>
        		<td>{{ number_format($arrayARI[$i]['remacumulada'], 2, ',', '.') }}</td>
        		<td>{{ number_format($arrayARI[$i]['impacumulado'], 2, ',', '.') }}</td>
        	</tr>
        </tbody>
		@endfor
	</table>
	<table style="font-size: 9px; text-align: center;" width="100%" class="table table-sm">
		<thead>
			<tr style="height: 5px;">
				<td colspan="3" style="text-align: center;"><h5>DEDUCCIONES DE LEY</h5></td>
			</tr>
		</thead>
	    <tbody>
	    @foreach ($deducciones as $deduccion)
	    	<tr>
	    		<td>{{ $deduccion->cod_concep }}</td>
	    		<td>{{ $deduccion->descrip_corta }}</td>
	            <td>{{ number_format($deduccion->total_d, 2, ',', '.') }}</td>
	        </tr>
	    @endforeach
	    </tbody>
	</table>
		<br>
		<br>
		AGENTE DE RETENCION (SELLO, FECHA Y FIRMA)
		
		
                   		
<div id="footer">
	<div class="text-center">
	<pre style="font-size: 9px">
        <strong>"Vigilando la Salud de todos y todas"</strong>
        Dirección: Carrera 3 con calle 09, Antiguo Hospital sector Curazao Guanare - Portuguesa - Venezuela - 
        Teléfono: 0257-2512246  - <a href="#">http://www.gestion-saludportuguesa.org.ve</a>
        </pre>
     </div>
</div>                   
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>