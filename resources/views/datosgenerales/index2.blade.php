@extends('app')



@section('contenido')


<div class="card-body">
        @include('flash::message')
        
         <div class="row">
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    <h3>Cedula</h3>
                    {{ $request->Cedula }}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <h3>Nombre y Apellido</h3>
                    {{ $dato->nombre }}  {{ $dato->apellidos }}
                </div>
            </div>
            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                <div class="form-group">
                    <h3>Fecha de Ingreso</h3>
                    {{ $dato->f_ingInstitucion }} 
                </div>
            </div>   
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                     <h3>Cargo</h3>
                    {{ $dato->cargo }} 
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <h3>Dependencia</h3>
                    {{ $dato->dependencia }} 
                </div>
            </div>  
        </div>
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">Periodo a Consultar {{ $request->MesConsulta }}-{{ $request->AnnoConsulta }}</h4>
        </div>
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">Nominas canceladas en el periodo</h4>
        </div>
        <div class="row">
            <div class="col-6 col-md"> 
            <div class="form-group">
                 <input type="radio" name="opnom" value="{{$periodo}}">MOSTRAR PERIODO COMPLETO<br>  
                 @foreach($detalles as $detalle)
                    <input type="radio" name="opnom" value="{{$detalle->cod_docu}}">{{$detalle->detalle}}<br>
                 @endforeach
            </div>
            </div>

        </div>  
        
        <input type="hidden" name="MesConsulta" value="{{ $request->MesConsulta }}">
        <input type="hidden" name="MesConsulta" value="{{ $request->AnnoConsulta }}">
        <input type="hidden" name="MesConsulta" value="{{ $periodo }}">
        <button type="submit" class="btn btn-lg btn-block btn-primary">Generar Recibo</button>
        
       

      </div>

@endsection