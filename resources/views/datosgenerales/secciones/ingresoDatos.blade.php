<div id="app">
        <div class="container">
     
        <div class="card-deck mb-12 text-center">
            <div class="card mb-12 shadow-sm">
            
            <div class="card-header" v-show="idicadorBusqueda == true">
                
                    <img src="{{ asset('img/loading.gif') }}" width="120px" height="120px">
                                <h5 class="my-0 font-weight-normal">Buscando...</h5>
            </div>

           
            

            <div class="card-header" v-show="idicadorBusqueda == false">
                <h4 class="my-0 font-weight-normal">Ingresa los datos del Trabajador</h4>
            </div>

            <div class="card-body">
                @include('flash::message')
                
               
                <div v-show="errorForm" class="columns text-center">
                    <div class="alert alert-danger" role="alert">
                            <div class="column text-left text-danger">
                                    <div v-for="error in errorMessageForm">
                                        @{{ error }}
                                    </div>
                            </div>
                    </div>
                </div>
                <form action="" method="POST" v-on:submit.prevent="enviarDatosTrab"> 
                
                <div class="row">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                             <label for="Cedula">Número de Cédula</label>
                             <input type="number" placeholder="ej:19188435" name="Cedula" v-model.number="numCedula" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            
                            <label for="Mes">Mes de Ingreso</label>
                            <select name="Mes" v-model="mesIngreso" id="" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="Año">Año de ingreso</label>
                                <select name="Anno" class="form-control" id="" v-model.number="anioIngreso">
                                        <option value="">Seleccione</option>
                                    @for ($i = 1960; $i <= gmdate('Y'); $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                        </div>
                    </div>   
                
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                    
                        <br>
                        <button v-show="idicadorBusqueda == false" type="submit" name="buscar" class="btn btn-block btn-primary">Buscar</button>
                        
                    </div> 

            
                </div>
                </form>
            </div>
            </div>       
        
        </div>
@include('datosgenerales.secciones.datosModal')
@include('datosgenerales.secciones.errorDatosModal')
<!-- <pre>
@{{ $data }}
</pre> -->
  
</div>
