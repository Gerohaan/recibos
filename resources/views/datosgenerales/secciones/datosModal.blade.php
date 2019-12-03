<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>-->



<!-- Trigger the modal with a button -->


<!-- Modal -->
<div class="modal fade" id="datosTrabajador" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>Datos del trabajador</strong></h5>
        <strong>Estatus: @{{ vdato.status }}</strong>
      </div>
      <div class="modal-body">
        
        <table class="table table-responsive">
         
            <tr>

              <th>NOMBRE Y APELLIDOS:</th>
              <td> @{{ vdato.nombre }} @{{ vdato.apellidos }} </td>
              <th>NOMINA:</th>
              <td> @{{ vdato.id_nomina }} @{{ vdato.denominacion }} @{{ vdato.condicion }} </td>
              <th>CARGO:</th>
              <td> @{{ vdato.cargo }} </td>
              
            </tr>
          
        </table>

  <!-- ///////////////////////////////////////////////////////////////////////////////////- -->

        <div class="row" v-if="idicadorSeleccion == false">
            
            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <div class="card">
              <div align="center">
                <p> 
                  <img src="{{ asset('img/recibos1.png') }}" width="130px" height="125px">
                </p>
              </div>
                <div class="card-body">
                  <h5 class="card-title">Recibo de Pago</h5>
                  <button type="button" @click.prevent="consultaSeleccion('recibos')" class="btn btn-primary">Consultar</button>
                </div>
              </div>
            </div>
            
            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <div class="card">
              <div align="center">
                <p>
                  <img src="{{ asset('img/constancias1.png') }}" width="150px" height="125px">
              </div>
                <div class="card-body">
                  <h5 class="card-title">Constancia de Trabajo</h5>
                  <button type="button" @click.prevent="consultaSeleccion('constancias')" class="btn btn-primary">Consultar</button>
                </div>
              </div>
            </div>

            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
            <div class="card">
              <div align="center">
                <p>
                  <img src="{{ asset('img/isrl1.png') }}" width="130px" height="125px">
              </div>
                <div class="card-body">
                  <h5 class="card-title">ARC - ISLR</h5>
                  <button type="button" @click.prevent="consultaSeleccion('ISRL')" class="btn btn-primary">Consultar</button>
                </div>
              </div>
            </div>
          
          
          </div>

 <!-- ///////////////////////////////////////////////////////////////////////////////////- -->

          <div v-else>

              <div class="row" v-show="idicadorRecibo == true">

                    <div class="col-sm-12 col-xs-12 col-md-5 col-lg-5">

                        <div v-show="errorForm" class="columns text-center">
                            <div class="alert alert-danger" role="alert">
                                <div class="column text-left text-danger">
                                        <div v-for="error in errorMessageForm">
                                            @{{ error }}
                                        </div>
                                </div>
                            </div>
                       </div>

                      <div class="card">
                        <form action="" method="POST" class="form-inline" v-on:submit.prevent="recibos">
                            
                            
                            <div class="card-body">
                              <h5 class="card-title"><strong>Recibos de Pago</strong></h5>
                                <strong>Seleccione año y mes a consultar.</strong>
                              <p class="card-text">
                              <strong>Año</strong>
                                <select name="anioConsulta" id="" v-model="AnioConsulta" class="form-control">
                                  <option value="">Año</option>
                                  <option value="{{ gmdate('Y') }}">{{ gmdate('Y') }}</option>
                                  <option value="{{ gmdate('Y')-1 }}">{{ gmdate('Y')-1 }}</option>
                                </select>
                              <strong>Mes</strong>
                                <select name="mesConsulta" id="" v-model="MesConsulta" class="form-control">
                                  <option value="">Mes</option>
                                  <option value="ENE">Enero</option>
                                  <option value="FEB">Febrero</option>
                                  <option value="MAR">Marzo</option>
                                  <option value="ABR">Abril</option>
                                  <option value="MAY">Mayo</option>
                                  <option value="JUN">Junio</option>
                                  <option value="JUL">Julio</option>
                                  <option value="AGO">Agosto</option>
                                  <option value="SEP">Septiembre</option>
                                  <option value="OCT">Octubre</option>
                                  <option value="NOV">Noviembre</option>
                                  <option value="DIC">Diciembre</option>
                                </select>
  
                              <button v-show="solicitarRecibo == false" type="submit" class="btn btn-primary">Consultar</button>
                              </p>
                             
                              
                            </div>
                        </form>
                      </div>
                    </div>


                     <div align="center" v-show="solicitarRecibo == true" class="col-sm-12 col-xs-12 col-md-7 col-lg-7">
                        <div class="card" align="center">
                        <p> 
                          <img src="{{ asset('img/loading.gif') }}" align="center" width="120px" height="120px">
                                <h5 class="my-0 font-weight-normal">Consultando...</h5>
                        <p>                        
                        </div>
                     </div>

                     <div align="center" v-show="solicitarRecibo == false" class="col-sm-12 col-xs-12 col-md-7 col-lg-7">
                            <div class="card" v-show="vrosters.length" >
                                  
                                                  
                                    
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                        <th colspan="2">Periodo consultado:  @{{ MesConsulta }} @{{ AnioConsulta }}</th>
                                        </tr>
                                          <tr>
                                            
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Selección <input type="checkbox" class="form-control" v-model="todasQuincenasSelec" @click="marcarQuicenas"></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr v-for="valor in vrosters">
                                           
                                            <td>@{{ valor.description }}</td>
                                            <td>

                                            <input v-model="numQuincena" :value="valor.cod_docu" type="checkbox" class="form-control">
                        
                                            </td>
                                          </tr>
                                        </tbody>
                                  </table>
                                  
                                  <table class="table">
                                    <tr>
                                      <th> 
                                          
                                          Total encontrados:   @{{ vrosters.length }} elementos. 
                                          
                                     </th>
                                     <th> 
                                          <button v-if="numQuincena.length" type="button" @click="descargarRecibo" class="btn btn-primary">Descargar</button>
                                          <button v-else type="button" class="btn btn-primary" disabled>Descargar</button> 
                                     </th>
                            
                                    
                                    </tr>
                                  </table>
                                  
                                  
                                  
                                  
                                                  
                            </div>
                     </div>


              </div>


              <div class="row" v-show="idicadorConstancia == true">
                  


                    <div v-show="solicitarConstancia == true" class="col-sm-12 col-xs-12 col-md-12 col-lg-12">

                          
                        
                        <div class="card" align="center">
                        <p> 
                          <img src="{{ asset('img/loading.gif') }}" align="center" width="120px" height="120px">
                                <h5 class="my-0 font-weight-normal">Consultando...</h5>
                        <p>                        
                        </div>
                        

                    </div>
                    <div v-show="solicitarConstancia == false" class="col-sm-12 col-xs-12 col-md-12 col-lg-12">

                          <div v-show="errorForm" class="columns text-center">
                              <div class="alert alert-danger" role="alert">
                                  <div class="column text-left text-danger">
                                          <div v-for="error in errorMessageForm">
                                              @{{ error }}
                                          </div>
                                  </div>
                              </div>
                          </div>

                          <!-- <div v-for="denominacion in denominacionConstancia"> -->

                             <div class="card" v-if="NumeroNominaTrabajador == 2">
                             
                                    <div class="card-body">
                                              <h5 class="card-title"><strong>Seleccione Nomina</strong></h5>
                                              
                                              <p class="card-text">
                                              <label for="tipo"><strong>Nomina</strong></label>
                                              <select name="tiponomina" v-model="tipoNomina" class="form-control">
                                              <option value="0">Seleccione</option>
                                              <option value="1">@{{ nominaNormal }}</option>
                                              <option value="2">@{{ nominaAltoNivel }}</option>
                                              </select>
                                              </p>
                                            
                                    </div>

                                      <div v-if="this.tipoNomina == 0" class="card-body">
                                              
                                              <h5>Selecione Nomina a consultar</h5>
                                          
                                      </div>

                                      <div v-if="this.tipoNomina == 1" class="card-body">
                                              
                                            <form action="" method="POST" v-on:submit.prevent="consultarConstancia(idNomNormal)">
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title"><strong>Constancia de Trabajo</strong><p> @{{ nominaNormal }} </p> </h5>
                                                    
                                                    <p class="card-text">
                                                    <label for="tipo"><strong>Tipo de Constancia</strong></label>
                                                    <select name="tipoConstancia" v-model="TipoConstanciaN" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">Normal</option>
                                                    <option value="2">Sueldo Base</option>
                                                    <option value="3">Sueldo Integral</option>
                                                    </select>
                                                    </p>
                                                    
                                                    <button type="submit" v-if="buscandoDatosConstancia == true" class="btn btn-primary" disabled>Descargar</button>
                                                    <button type="submit" v-else class="btn btn-primary">Descargar</button>
                                                </div>
                                          
                                          </form>
                                              
                                      </div>


                                      <div v-if="this.tipoNomina == 2" class="card-body">

                                          <form action="" method="POST" v-on:submit.prevent="consultarConstancia(idNomAltonivel)">
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title"><strong>Constancia de Trabajo</strong><p> @{{ nominaAltoNivel }} </p> </h5>
                                                    <p class="card-text">
                                                    <label for="tipo"><strong>Tipo de Constancia</strong></label>
                                                    <select name="tipoConstancia" v-model="TipoConstanciaA" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">Normal</option>
                                                    <option value="2">Sueldo Base</option>
                                                    <option value="3">Sueldo Integral</option>
                                                    </select>
                                                    </p>
                                                  
                                                    <button type="submit" v-if="buscandoDatosConstancia == true" class="btn btn-primary" disabled>Descargar</button>
                                                    <button type="submit" v-else class="btn btn-primary">Descargar</button>
                                                </div>
                                            
                                            </form>

                                      </div>

                             </div>

                             <div class="card" v-else>
                             
                                  <form action="" method="POST" v-on:submit.prevent="consultarConstancia(idNomNormal)">
                                        
                                        <div class="card-body">
                                            <h5 class="card-title"><strong>Constancia de Trabajo</strong><p> @{{ nominaNormal }} </p> </h5>
                                            
                                            <p class="card-text">
                                            <label for="tipo"><strong>Tipo de Constancia</strong></label>
                                            <select name="tipoConstancia" v-model="TipoConstanciaN" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Sueldo Base</option>
                                            <option value="3">Sueldo Integral</option>
                                            </select>
                                            </p>
                                            
                                            <button type="submit" v-if="buscandoDatosConstancia == true" class="btn btn-primary" disabled>Descargar</button>
                                            <button type="submit" v-else class="btn btn-primary">Descargar</button>
                                        </div>
                                        
                                  </form>

                             </div>

                                        
                          <!--  </div> -->

                    </div>
                    <div v-show="solicitarConstancia == false" class="col-sm-12 col-xs-12 col-md-12 col-lg-12">

                          
                      <div v-show="buscandoDatosConstancia == true" align="center">
                        <p> 
                          <img src="{{ asset('img/loading.gif') }}" align="center" width="120px" height="120px">
                                <h5 class="my-0 font-weight-normal">Consultando...</h5>
                        <p> 
                      </div>
                      
                      

                    </div>

              </div>

              <div class="row" v-show="idicadorIsrl == true">

                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                          <div class="card">
                                    
                          <div v-show="errorForm" class="columns text-center">
                              <div class="alert alert-danger" role="alert">
                                  <div class="column text-left text-danger">
                                          <div v-for="error in errorMessageForm">
                                              @{{ error }}
                                          </div>
                                  </div>
                              </div>
                          </div>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><strong>ARC - ISLR</strong><p>  </p> </h5>
                                        <p class="card-text">
                                        <label for="tipo"><strong>Año a consultar</strong></label>
                                        <select name="" v-model="anioisrl" id="" class="form-control">
                                        <option value="" selected>Año</option>
                                        <option value="{{ gmdate('Y') }}">{{ gmdate('Y') }}</option>
                                        <option value="{{ gmdate('Y')-1 }}">{{ gmdate('Y')-1 }}</option>
                                        </select>
                                        </p>
                                      
                                        <button type="button" v-if="buscandoisrl == false" @click="isrl" class="btn btn-primary">Descargar</button>
                                        <button v-else class="btn btn-primary" disabled>Descargar</button>
                                    </div>
                                    
                                    
                                
                            </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" v-show="buscandoisrl == true">
                          
                                    
                                    
                          <div align="center">
                              <p> 
                                <img src="{{ asset('img/loading.gif') }}" align="center" width="120px" height="120px">
                                      <h5 class="my-0 font-weight-normal">Consultando...</h5>
                              <p> 
                          </div>    
                    
                                    
                                
                            
                    </div>

              </div>
              
              
              

          </div>

  <!-- ///////////////////////////////////////////////////////////////////////////////////- -->

      <div class="modal-footer">
        <button v-show="idicadorSeleccion == true" type="button" @click.prevent="volverSeleccion" class="btn btn-warning">Volver</button>
        <button type="button" class="btn btn-danger" @click="cerrarModal">Salir</button>
       <!-- <button type="button" class="btn btn-primary">Consultar</button> -->
       
      </div>
    </div>
  </div>
</div>