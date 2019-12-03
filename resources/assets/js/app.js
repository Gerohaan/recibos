

const app = new Vue({
    el: '#app',
    data: {
        
        numCedula: '',
        mesIngreso: '',
        anioIngreso: '',
        vdatosGenerales: [],
        vrequest: [],
        vdato: [],
        vperiodo: [],
        vdetalles: [],
        errors: [],
        errorMessageForm: [],
        errorForm: '',
        AnioConsulta: '',
        MesConsulta: '',
        IdTrab: null,
        vrosters: [],
        numQuincena: [],
        todasQuincenasSelec: false,
        idicadorBusqueda: false,
        idicadorSeleccion: false,
        idicadorRecibo: false,
        idicadorConstancia: false,
        idicadorIsrl: false,
        solicitarRecibo: false,
        solicitarConstancia: false,
        solicitarIsrl: false,
        denominacionConstancia: [],
        NumeroNominaTrabajador: null,
        buscandoDatosConstancia: false,
        buscandoisrl: false,
        anioisrl: '',
        IdNomina: null,
        TipoConstanciaA: null,
        TipoConstanciaN: null,
        nominaAltoNivel: "",
        idNomAltonivel: null,
        nominaNormal: "",
        idNomNormal: null,
        tipoNomina: 0
    },
    methods: {

        validarForm: function() {
            this.errorForm = 0;
            this.errorMessageForm = [];
            if (!this.numCedula) this.errorMessageForm.push('El campo Cedula no puede estar vacío.');
            if (!this.mesIngreso) this.errorMessageForm.push('El campo Mes de Ingreso no puede estar vacío.');
            if (!this.anioIngreso) this.errorMessageForm.push('El campo Año de ingreso no puede estar vacío.');
            if (this.errorMessageForm.length) this.errorForm = 1;
            return this.errorForm;
        },

        validarFormRecibos: function() {
            this.errorForm = 0;
            this.errorMessageForm = [];
            if (!this.AnioConsulta) this.errorMessageForm.push('El campo Año a consultar no puede estar vacío.');
            if (!this.MesConsulta) this.errorMessageForm.push('El campo Mes a consultar no puede estar vacío.');
            if (this.errorMessageForm.length) this.errorForm = 1;
            return this.errorForm;
        },

        validarFormISRL: function() {
            this.errorForm = 0;
            this.errorMessageForm = [];
            if (!this.anioisrl) this.errorMessageForm.push('El campo Año no puede estar vacío.');
            if (this.errorMessageForm.length) this.errorForm = 1;
            return this.errorForm;
        },

        validarConstanciaN: function() {
            this.errorForm = 0;
            this.errorMessageForm = [];
            if (!this.TipoConstanciaN) this.errorMessageForm.push('El campo Tipo de Constancia no puede estar vacío.');
            if (this.errorMessageForm.length) this.errorForm = 1;
            return this.errorForm;
        },

        validarConstanciaA: function() {
            this.errorForm = 0;
            this.errorMessageForm = [];
            if (!this.TipoConstanciaA) this.errorMessageForm.push('El campo Tipo de Constancia no puede estar vacío.');
            if (this.errorMessageForm.length) this.errorForm = 1;
            return this.errorForm;
        },
        
        cerrarModal: function() {

            
            if(confirm('Esta seguro que desea cancelar la consulta? Por seguridad, será recargada la página'))
            {
                
                window.location.href = "";
                

            }else
            {
                return false;
            }
            
                 

        },

        consultaSeleccion: function(opcion) {

            switch (opcion) {
                
                case 'recibos':

                    this.idicadorRecibo = true;
                    this.idicadorSeleccion = true;
                    this.errorForm = 0;
                    this.errorMessageForm = [];
                
                break;

                case 'constancias':

                    this.idicadorConstancia = true;
                    this.idicadorSeleccion = true;

                    ///////////////////////////////
                    const idTrabajador = this.IdTrab;
                    const url = 'datos/constancias/'+idTrabajador;
                    this.solicitarConstancia = true;
                    axios.get(url).then(response => {
                        

                        this.errorForm = 0;
                        this.errorMessageForm = [];

                        this.solicitarConstancia = false;
                        this.denominacionConstancia = response.data.denominacion;
                        this.NumeroNominaTrabajador = response.data.nominas;
                        //console.log(response.data)
                        if(this.NumeroNominaTrabajador === 2)
                        {
                            this.nominaNormal = this.denominacionConstancia[0].den;
                            this.idNomNormal = this.denominacionConstancia[0].id;
                            this.nominaAltoNivel = this.denominacionConstancia[1].den;
                            this.idNomAltonivel = this.denominacionConstancia[1].id;
                            console.log(response.data)
                        }else if(this.NumeroNominaTrabajador === 1)
                        { 
                            this.nominaNormal = this.denominacionConstancia[0].den;
                            this.idNomNormal = this.denominacionConstancia[0].id;
                            console.log(response.data)
                        }else
                        {
                            console.log('pendiente por configurar mas de dos nominas existentes en el trabajor')
                        }
                        //console.log(response.data)
                    }).catch(error => {
                        this.solicitarConstancia = false;
                        console.log(error)
                    })
                
                break;

                case 'ISRL':

                    this.idicadorIsrl = true;
                    this.idicadorSeleccion = true;
                    this.errorForm = 0;
                    this.errorMessageForm = [];
                
                break;
            }

        },

        ///revisar metodo
        traducirCodigoQuinc: function(nro_quinc){
          
           return nro_quinc.replace(/this.CodigosQuincenas/, this.CodigosTraducidos); 
        },
        /////////////////
        

        marcarQuicenas: function() {

            this.numQuincena = [];
			if (!this.todasQuincenasSelec) {
				for (let i in this.vrosters) {
					this.numQuincena.push(this.vrosters[i].cod_docu);
				}
			}
        },

        recibos: function() {
            
            this.vrosters = [];

            if (this.validarFormRecibos()) {
                return;
            }

            this.solicitarRecibo = true;
            
            const url = 'datos/roster';

            axios.post(url, {

                anioConsulta: this.AnioConsulta,
                mesConsulta: this.MesConsulta,
                id_trab: this.IdTrab,

            }).then(response => {
                
                this.solicitarRecibo = false;

                if(response.data.noEncontrado)
                {
                    
                    toastr.error(response.data.noEncontrado, 'No encontrado', { timeOut: 9500,  positionClass: "toast-top-full-width"});
                
                }else
                {

                    //console.log(response.data);
                    //this.vrosters = response.data.rosters;
                    this.vrosters = response.data.nominas;
                   // console.log(response.data);
                    

                }

            }).catch(error => {


                
                
                
                this.errorMessageForm = [];
                this.errorForm = 0;
                if (error.response.data && error.response.status === 500) {
                    console.log(error.response.data)
                }
                if (error.response && error.response.status === 422) {
                    
                    this.errorForm = 1;
                    erroresdevalidacion = this.errorMessageForm; 
                    this.idicadorBusqueda = false; 
                    
                    if(error.response.data.errors.anioConsulta)
                    {    
                            error.response.data.errors.anioConsulta.forEach(function (element) {
                            erroresdevalidacion.push(element);
                            });

                            console.clear();
                           
                    }

                    if(error.response.data.errors.mesConsulta)
                    {

                        error.response.data.errors.mesConsulta.forEach(function (element) {
                            erroresdevalidacion.push(element);
                            });

                            console.clear();

                    }

                    
                    
                } else {
                    console.log(error);
                }

            });
        

        },

        descargarRecibo: function()
        {
            if(this.numQuincena.length === 0 )
            {
                toastr.error('Seleccione al menos un elemento de la lista.', '<strong>Vacío</strong>', { timeOut: 9500 , positionClass: "toast-top-full-width"});
            }else
            {
                
                               
                const idTrabajador = this.IdTrab;
                const codigoQuincena = this.numQuincena;
                const url = 'datos/reciboPDF/'+idTrabajador+"/"+codigoQuincena;
                this.todasQuincenasSelec = false;
                this.numQuincena = [];
                window.open(url, "Recibo de Pago", "width=500, height=400");
                toastr.success('Espere mientras procesamos su solicitud.', '<strong>Correcto</strong>', { timeOut: 9500 , positionClass: "toast-top-full-width"});
                
                
            }
            
        },

        consultarConstancia: function(idNom) {

                
                if(!this.TipoConstanciaA)
                {
                    if (this.validarConstanciaN()) {
                        return;
                    }
                }else
                {
                    if (this.validarConstanciaA()) {
                        return;
                    }
                }

                this.buscandoDatosConstancia = true;
                
                if(!this.TipoConstanciaA)
                {
                    tipoConstancia = this.TipoConstanciaN;
                }else
                {
                    tipoConstancia = this.TipoConstanciaA;
                }
                const url = 'datos/consultaConstancia/'+this.IdTrab+'/'+idNom+'/'+tipoConstancia;
                axios.get(url).then(response => {

                    this.buscandoDatosConstancia = false;
                    toastr.success('Espere mientras procesamos su solicitud.', '<strong>Correcto</strong>', { timeOut: 9500 , positionClass: "toast-top-full-width"});
                    window.open(url, "Constancia de Trabajo", "width=500, height=400");
                        
                    
                    

                }).catch(error => {
                        
                    this.buscandoDatosConstancia = false;
                    console.log(error.response)
                    //console.log(idNom)
                    //console.log(tipoConstancia)
                    //console.log(this.IdTrab)
                    //console.log(url)

                })
        },

        isrl: function() {
            
            if (this.validarFormISRL()) {
                return;
            }
             this.buscandoisrl = true;
             const url = 'datos/isrl/'+this.IdTrab+'/'+this.anioisrl;
             axios.get(url).then(response => {
                 
                this.buscandoisrl = false;
                toastr.success('Espere mientras procesamos su solicitud.', '<strong>Correcto</strong>', { timeOut: 9500 , positionClass: "toast-top-full-width"});
                window.open(url, "ARC - ISRL", "width=500, height=400");
             }
            ).catch(error => {
                
                this.buscandoisrl = false;
                console.log(error.response)
                
            })
        },

        volverSeleccion: function() {

            this.idicadorRecibo = false;
            this.idicadorConstancia = false;
            this.idicadorIsrl = false;
            this.idicadorSeleccion = false;
            
          
        },

        enviarDatosTrab: function() {

            if (this.validarForm()) {
                return;
            }
            this.idicadorBusqueda = true; 
            var url = 'datos/query';
            axios.post(url, {
              
                //igualar campos de vue can campos de blade
                Cedula: this.numCedula,
                Mes: this.mesIngreso,
                Anno: this.anioIngreso,
                
            }).then(response => {

                if(response.data.errorDatos)
                {
                    this.idicadorBusqueda = false;
                    toastr.error('Verifique Cedula o Fecha de Ingreso', 'No encontrado', { timeOut: 9500, positionClass: "toast-top-full-width"} );
                }else
                {
                    //limpiar variables empleadas en la accion del usuario
                    this.numCedula = '';
                    this.mesIngreso = '';
                    this.anioIngreso = '';
                    this.errors = [];
                    this.errorMessageForm = [];
                    this.errorForm = 0;
                    this.idicadorBusqueda = false; 
                    this.vrequest = response.data.request;
                    this.vdato = response.data.dato;
                    this.vperiodo = response.data.periodo;
                    this.IdTrab = response.data.dato.id_trab;
                    
                   
                    $('#datosTrabajador').modal('show');
                }

            }).catch(error => {

                
                
                this.errorMessageForm = [];
                this.errorForm = 0;
                if (error.response.data && error.response.status === 500) {
                    console.log(error.response.data)
                }
                if (error.response && error.response.status === 422) {
                    
                    this.errorForm = 1;
                    erroresdevalidacion = this.errorMessageForm; 
                    this.idicadorBusqueda = false; 
                    
                    if(error.response.data.errors.Cedula)
                    {    
                            error.response.data.errors.Cedula.forEach(function (element) {
                            erroresdevalidacion.push(element);
                            });

                            console.clear();
                            
                    }

                    if(error.response.data.errors.Mes)
                    {

                        error.response.data.errors.Mes.forEach(function (element) {
                            erroresdevalidacion.push(element);
                            });

                            console.clear();

                    }

                    if(error.response.data.errors.Anno)
                    {
                        error.response.data.errors.Anno.forEach(function (element) {
                            erroresdevalidacion.push(element);
                            });

                            console.clear();
                        
                    }

                    
                    
                } else {
                    console.log(error);
                }

            });
        }
    }
});
