<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datosgenerale;
use App\Dependencia;
use App\Nomina;
use App\Histo_nom_detconcep;
use App\Quincena;
use App\Mov_nom;
use App\Perso_enomina;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\datosIngreRequest;
use App\Http\Requests\recibosRequest;
//Importar librería
use NumeroALetras\NumeroALetras;
use Carbon\Carbon;

class DatosgeneralesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos= DB::table('datosgenerales')->where('status','=', 'ACTIVO')
                                   ->get();
        //dd($datos);
        $title="Listado";
        return view('datosgenerales.index',compact('title','datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $fec_ing=$request->Anno.'-'.$request->Mes;
        $existe=Datosgenerale::where('cedula','=', $request->Cedula)
                             ->where('f_ingInstitucion','LIKE','%'.$fec_ing.'%')
                             ->exists();
        //dd($existe);
        //return response()->json($request);
        //exit;
        if($existe){
        $dato=Datosgenerale::where('cedula','=', $request->Cedula)
                             ->where('f_ingInstitucion','LIKE','%'.$fec_ing.'%')
                             ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                             ->join('nominas','nominas.id','datosgenerales.id_nomina')
                             ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                             ->join('formapago','formapago.id','datosgenerales.idformapago')
                             ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                             ->select('datosgenerales.*','dependencias.nombre as dependencia','dependencias.responsable as jefe','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                             ->firstOrFail();
        //dd($dato);
        
            $periodo=$request->MesConsulta.$request->AnnoConsulta;
            //DD($periodo);
            $detalles=DB::table('hist_nom_dettrab')->select('hist_nom_dettrab.*','mov_nom.detalle')
                                            ->where('hist_nom_dettrab.id_trab','=',$dato->id_trab)
                                            ->where('mov_nom.nro_quinc','LIKE','%'.$periodo.'%')
                                            ->join('mov_nom','mov_nom.cod_docu','hist_nom_dettrab.cod_docu')
                                            ->get();
            //dd($detalles);
            ///return view ("datosgenerales.index2",compact("request","dato","detalles","periodo"));
            //return Response::json($request,$dato,$detalles,$periodo);
            //return compact("request","dato","detalles","periodo");
            return response()->json($request,$dato,$detalles,$periodo);
            //$pdf = \PDF::loadView("datosgenerales.show",compact("dato","detalles","periodo","letras"));
            // (Optional) Setup the paper size and orientation
            //$pdf->setPaper('letter', 'portrait');

            // Output the generated PDF to Browser
            //$dompdf->stream();
            //return $pdf->stream($dato->cedula.'.pdf'); 
        }else{
            return response()->json("Error de datos");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function show($id)
    {
        $dato=Datosgenerale::where('cedula','=', $id)
                             ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                             ->join('nominas','nominas.id','datosgenerales.id_nomina')
                             ->select('datosgenerales.*','dependencias.nombre as dependencia','nominas.denominacion')
                             ->firstOrFail();
        //dd($dato);
        //$detalles=Histo_nom_detconcep::where('id_trab','=',$dato->id_trab)
        $detalles=DB::table('histo_nom_detconcep')->where('id_trab','=',$dato->id_trab) 
                                        ->where('cod_docum','LIKE','%MAR2019%')                               
                                        ->join('concepto','concepto.cod_conc','histo_nom_detconcep.cod_concep')
                                        ->select('histo_nom_detconcep.cod_concep','concepto.descripcion','histo_nom_detconcep.asignacion','histo_nom_detconcep.deduccion', 
                                                DB::raw('sum(histo_nom_detconcep.asignacion) as total_a'), 
                                                DB::raw('sum(histo_nom_detconcep.deduccion) as total_d'))
                                        ->groupBy('histo_nom_detconcep.cod_concep','concepto.descripcion','histo_nom_detconcep.asignacion','histo_nom_detconcep.deduccion')
                                        ->get();
        //dd($detalles);
        return view ("datosgenerales.show",compact("dato","detalles"));
    }
    public function query(datosIngreRequest $request){
        //dd($request);
        $fec_ing=$request->Anno.'-'.$request->Mes;
        $existe=Datosgenerale::where('cedula','=', $request->Cedula)
                             ->where('f_ingInstitucion','LIKE','%'.$fec_ing.'%')
                             ->exists();
        //dd($existe);
        if($existe){
        $dato=Datosgenerale::where('cedula','=', $request->Cedula)
                             ->where('f_ingInstitucion','LIKE','%'.$fec_ing.'%')
                             ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                             ->join('nominas','nominas.id','datosgenerales.id_nomina')
                             ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                             ->join('formapago','formapago.id','datosgenerales.idformapago')
                             ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                             ->select('datosgenerales.*','dependencias.nombre as dependencia','dependencias.responsable as jefe','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                             ->firstOrFail();
        //dd($dato);
        
            $periodo=$request->MesConsulta.$request->AnnoConsulta;
            //DD($periodo);
            $detalles=DB::table('hist_nom_dettrab')->select('hist_nom_dettrab.*','mov_nom.detalle')
                                            ->where('hist_nom_dettrab.id_trab','=',$dato->id_trab)
                                            ->where('mov_nom.nro_quinc','LIKE','%'.$periodo.'%')
                                            ->join('mov_nom','mov_nom.cod_docu','hist_nom_dettrab.cod_docu')
                                            ->get();
            //dd($detalles);
           //// return view ("datosgenerales.index2",compact("request","dato","detalles","periodo"));
            ///return Response::json($request,$dato,$detalles,$periodo);
            ////return compact("request","dato","detalles","periodo");
            return response()->json(['request' => $request, 'dato' =>$dato, 'detalles' =>$detalles, 'periodo' =>$periodo]);
            //return compact('detalles');
            ///////return view ("datosgenerales.index2",compact("request","dato","detalles","periodo"));
            //$pdf = \PDF::loadView("datosgenerales.show",compact("dato","detalles","periodo","letras"));
            // (Optional) Setup the paper size and orientation
            //$pdf->setPaper('letter', 'portrait');

            // Output the generated PDF to Browser
            //$dompdf->stream();
            //return $pdf->stream($dato->cedula.'.pdf'); 
        }else{
            //flash('No existe registro de trabajadores con estos datos verifique la cedula y la fecha de ingreso')->error();
            //return redirect()->route('datos.index');
            return response()->json(['errorDatos' => "Verifique Cedula o Fecha de Ingreso"]);
        }

    }
     public function queryii(Request $request){
        //dd($request);     
        $dato=Datosgenerale::where('cedula','=', $request->Cedula)
                             ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                             ->join('nominas','nominas.id','datosgenerales.id_nomina')
                             ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                             ->join('formapago','formapago.id','datosgenerales.idformapago')
                             ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                             ->select('datosgenerales.*','dependencias.nombre as dependencia','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                             ->firstOrFail();
        //dd($dato);
                //DD($request->opnom);
                //
                $detalles=DB::table('histo_nom_detconcep')->distinct()->where('id_trab','=',$dato->id_trab) 
                                                ->where('cod_docum','LIKE','%'.$request->opnom.'%')                               
                                                ->join('concepto','concepto.cod_conc','histo_nom_detconcep.cod_concep')
                                                ->select('histo_nom_detconcep.cod_concep','concepto.descripcion', 
                                                        DB::raw('sum(histo_nom_detconcep.asignacion) as total_a'), 
                                                        DB::raw('sum(histo_nom_detconcep.deduccion) as total_d'))
                                                ->groupBy('histo_nom_detconcep.cod_concep','concepto.descripcion')
                                                ->get();
                //dd($detalles);
                $subtotal_a=0;
                $subtotal_d=0;
                $total=0;
                foreach ($detalles as $detalle) {
                   $subtotal_a=$subtotal_a+($detalle->total_a*1);
                   $subtotal_d=$subtotal_d+($detalle->total_d*1);
                }
                $total=$subtotal_a-$subtotal_d;
                $letras=NumeroALetras::convertir($total, 'Bolivares');
                if ($request->opnom==$request->periodo) {
                    $quincena=Quincena::where('nro_quincena','=',$request->opnom)->select('desde','hasta','prim_seg as periodo')->firstOrFail();
                }else{
                    $q=Mov_nom::where('cod_docu','=',$request->opnom)->firstOrFail();
                    //dd($q);
                    $quincena=Quincena::where('nro_quincena','=',$q->nro_quinc)->select('desde','hasta','prim_seg as periodo')->firstOrFail();
                }
                $periodo=$request->periodo;
                //dd($periodo);
                //return view ("datosgenerales.show",compact("dato","detalles","periodo","letras","quincena"));
                $pdf = \PDF::loadView("datosgenerales.show",compact("dato","detalles","periodo","letras","quincena"));
                // (Optional) Setup the paper size and orientation
                $pdf->setPaper('letter', 'portrait');

                // Output the generated PDF to Browser
                //$dompdf->stream();
                return $pdf->stream($dato->cedula.'.pdf');
           
    }

    //Consulta las nominas del trabajador en un periodo
    public function query_roster(recibosRequest $request){
        $periodo=$request->mesConsulta.$request->anioConsulta;
        $id_trab=$request->id_trab;
        //$id_trab=318;
        //$periodo='FEB2019';
         $rosters=DB::table('hist_nom_dettrab')->select('hist_nom_dettrab.cod_docu','mov_nom.nro_quinc','mov_nom.cod_nom','mov_nom.tipo_nom','quincena.ejercicio_fiscal','nominas.denominacion','tipo_nomina.descripcion')
                                            ->where('hist_nom_dettrab.id_trab','=',$id_trab)
                                            ->where('mov_nom.nro_quinc','LIKE','%'.$periodo.'%')
                                            ->join('mov_nom','mov_nom.cod_docu','hist_nom_dettrab.cod_docu')
                                            ->join('quincena','quincena.nro_quincena','mov_nom.nro_quinc')
                                            ->join('nominas','nominas.id','mov_nom.cod_nom')
                                            ->join('tipo_nomina','tipo_nomina.id','mov_nom.tipo_nom')
                                            ->get();
        if(count($rosters) > 0)
        {

            //dd($rosters);
        $fila=0;
        foreach ($rosters as $roster) {
              $nominas[$fila]['cod_docu']=$roster->cod_docu;
              $index=substr($roster->cod_docu, 0, 1);
              $nominas[$fila]['description']="";
              if ($index == '1') {
                 $nominas[$fila]['description']="1era Quinc."; 
              }elseif ($index == '2') {
                 $nominas[$fila]['description']="2da Quinc."; 
              }
              $nominas[$fila]['description']=$nominas[$fila]['description']." ".$roster->descripcion;
            $fila++;
          }  
          
            return response()->json(['nominas' => $nominas]);
        }else{
            return response()->json(['noEncontrado' => "El período consultado (" .$periodo. ") no existe en la base de datos."  ]);
        }
        
    }

    public function print_pdf(){
       $pdf = \PDF::loadView("datosgenerales.show",compact("dato","detalles","periodo"));
        return $pdf->download($dato->cedula.'.pdf'); 
    }

    public function imprimirRecibo($idTrabajador,$codigoDocumento){
        //$idTrabajador=318;
        //$codigoDocumento = array('1FEB2019010101','2FEB2019010101','MFEB2019010104');
        //return $idTrabajador." y ".$codigoDocumento;
        //exit;
                $docu= explode(",",$codigoDocumento); ///////se agrego explode al codigo del documento
               
                $datostrab=Datosgenerale::where('id_trab','=', $idTrabajador)
                                     ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                                     ->join('nominas','nominas.id','datosgenerales.id_nomina')
                                     ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                                     ->join('formapago','formapago.id','datosgenerales.idformapago')
                                     ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                                     ->select('datosgenerales.*','dependencias.nombre as dependencia','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                                     ->firstOrFail();
                $fila=0;
                $fila2=0;
                
                for($i=0; $i<count($docu); $i++)
                {
                    $idnom=substr($docu[$i], 10, 2);
                    $encanominas=DB::table('hist_nom_dettrab as hn' )
                    ->join('mov_nom as mn', 'hn.cod_docu', '=', 'mn.cod_docu')
                    ->join('nominas as nm', 'mn.cod_nom', '=', 'nm.id')
                    ->join('tipo_nomina as tn', 'mn.tipo_nom', '=', 'tn.id')
                    ->join('cargos as car', 'hn.cod_cargo', '=', 'car.cod_clase')
                    ->select('hn.cod_docu', 'hn.idforpago', 'hn.sueldo_base', 'hn.grupo_tabla', 'hn.nivel_tabla', 'car.descripcion as cargo', 'car.grado', 'mn.nro_quinc', 'mn.desde', 'mn.hasta', 'mn.cod_nom', 'nm.denominacion', 'tn.descripcion')
                    ->where('hn.id_trab', '=', $idTrabajador)
                    ->where('hn.cod_docu', '=', $docu[$i])
                    ->get();  
                //dd($rosters);          
                    $detnominas=DB::table('histo_nom_detconcep as dhc')
                    ->join('concepto as con', 'dhc.cod_concep', '=', 'con.cod_conc')
                    ->select('dhc.cod_concep', 'con.descrip_corta', 'dhc.asignacion', 'dhc.deduccion', 'dhc.cod_docum')
                    ->where('dhc.id_trab', '=', $idTrabajador)
                    ->where('dhc.cod_docum', '=', $docu[$i])
                    ->get();                         
                
                        foreach($encanominas as $enca)
                         {
                          $arrayencanominas[$fila2]['cod_docu']=$enca->cod_docu;
                         if ($enca->idforpago=='1') {
                              $formadepago='TRANSFERENCIA';
                          }elseif ($enca->idforpago=='2') {
                             $formadepago='CHEQUE';
                          }
                          $arrayencanominas[$fila2]['idforpago']= $formadepago;
                          $arrayencanominas[$fila2]['sueldo_base']= $enca->sueldo_base;
                          $arrayencanominas[$fila2]['cargo']= $enca->cargo;
                          $arrayencanominas[$fila2]['grado']= $enca->grado;
                          $arrayencanominas[$fila2]['nro_quinc']= $enca->nro_quinc;
                          $arrayencanominas[$fila2]['desde']= $enca->desde;
                          $arrayencanominas[$fila2]['hasta']= $enca->hasta;
                          $arrayencanominas[$fila2]['cod_nom']= $enca->cod_nom;
                          $arrayencanominas[$fila2]['denominacion']= $enca->denominacion;
                          $arrayencanominas[$fila2]['descripcion']= $enca->descripcion; 
                          $index=substr($enca->cod_docu, 0, 1);
                          $arrayencanominas[$fila2]['nomina']="";
                          if ($index == '1') {
                             $arrayencanominas[$fila2]['nomina']="1era Quinc."; 
                          }elseif ($index == '2') {
                             $arrayencanominas[$fila2]['nomina']="2da Quinc."; 
                          }else{
                             $arrayencanominas[$fila2]['nomina']="";
                          }
                          $fila2++;
                         }
                         $subtotal_a=0;
                        $subtotal_d=0;
                        $total=0;
                        for($j=0; $j<count($detnominas); $j++)
                        {
                         $arraydetnominas[$fila]['cod_concep']= $detnominas[$j]->cod_concep;
                         $arraydetnominas[$fila]['descrip_corta']= $detnominas[$j]->descrip_corta;
                         $arraydetnominas[$fila]['asignacion']= $detnominas[$j]->asignacion;
                         $arraydetnominas[$fila]['deduccion']= $detnominas[$j]->deduccion;
                         $arraydetnominas[$fila]['cod_docum']= $detnominas[$j]->cod_docum;
                         $fila++;
                        
                        }
                                      
                    }
                        /*$pdf = \PDF::loadView("pdf.recibo",compact("datostrab","encanominas","detnominas"));
                        // (Optional) Setup the paper size and orientation
                        $pdf->setPaper('letter', 'portrait');
        
                        // Output the generated PDF to Browser
                        //$dompdf->stream();
                        return $pdf->stream('download.pdf');*/
                        $encanominas=$arrayencanominas;
                        $detnominas= $arraydetnominas;
                        $pdf = \PDF::loadView("pdf.recibo",compact("datostrab","encanominas","detnominas"));
                        
                        return $pdf->stream('download.pdf');
            }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    ///////////////////////////////////////////////////////////
    public function nominaConstancia($idTrabajador){
        //$idTrabajador=8043;
        //$idTrabajador = 198;
        $nominas=0;
        $datosAN=Perso_enomina::where('id_trab','=', $idTrabajador)
                                    ->where('activo','=', 'SI')
                                    ->join('nominas','nominas.id','perso_enomina.idnomina')
                                    ->select('perso_enomina.idnomina','nominas.denominacion')
                                    ->first();
        $datosG=Datosgenerale::where('id_trab','=',$idTrabajador)
                                    ->join('nominas','nominas.id','datosgenerales.id_nomina')
                                    ->select('datosgenerales.id_nomina','nominas.denominacion')
                                    ->firstOrFail();

                if($datosG){
                   $nominas=$nominas+1;
                   $denominacion[0]['id']=$datosG->id_nomina;
                   $denominacion[0]['den']=$datosG->denominacion;  
                }else{
                   $mensaje="No Exite el Trabajador";
                }
                if($datosAN){
                   if ($datosG->id_nomina!=$datosAN->idnomina) {
                       $nominas=$nominas+1;
                       $denominacion[1]['id']=$datosAN->idnomina;
                       $denominacion[1]['den']=$datosAN->denominacion;
                   }
                }else{
                   $mensaje="existe y no es alto nivel";
                }
            return response()->json(['denominacion' => $denominacion, 'nominas' =>$nominas]); 
    }
    ///////////////////////////////////////////////
    public function imprimirConstancia($idTrabajador, $tipoNomina, $tipoConstancia){
        $mes = Carbon::now()->format('m');
        $anno = Carbon::now()->format('Y');
        //$idTrabajador=198;
        //$tipoNomina="01";
        //$tipoConstancia="3";
        //return $idTrabajador." y ".$tipoNomina." y ".$tipoConstancia;
        
        $dato=Datosgenerale::where('id_trab','=', $idTrabajador)
                                ->where('status','=', 'ACTIVO')
                                ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                                ->join('nominas','nominas.id','datosgenerales.id_nomina')
                                ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                                ->join('formapago','formapago.id','datosgenerales.idformapago')
                                ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                                ->select('datosgenerales.*','dependencias.nombre as dependencia','dependencias.responsable as jeferrhh','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                                ->firstOrFail();
        $nomina=Nomina::where('id','=',$tipoNomina)
                            ->select('nominas.*')
                            ->firstOrFail();
        ///codigo para determinar si la nomina es alto nivel
        $tn="N";
        if ($tipoNomina=="07") {$tn="AN";}
        if ($tipoNomina=="11") {$tn="AN";}
        ///codigo para determinar si la nomina es alto nivel
        // que hacer dependiendo del tipo de constancia seleccionada
        if (($tn=="N")) {
        $cargoconstancia=$dato->cargo;
        $fec_ing=date('d/m/Y', strtotime($dato->f_ingInstitucion));
           if ($tipoConstancia=="1") {
                $pdf = \PDF::loadView("pdf.const_base",compact("dato","nomina","cargoconstancia","fec_ing"));
                return $pdf->stream('download.pdf');
                //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing]); 
            }elseif ($tipoConstancia=="2") {
                $sb=$dato->sueldo;
                $letras=NumeroALetras::convertir($sb, 'Bolivares');
                $pdf = \PDF::loadView("pdf.const_sb",compact("dato","nomina","cargoconstancia","fec_ing","sb","letras"));
                return $pdf->stream('download.pdf');
                //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing,'sb' =>$sb,'letras' => $letras]);
            }elseif ($tipoConstancia=="3") {
            $annoant=$anno-1;
            while($anno>=$annoant){
                while($mes>=1) {
                   if ($mes==1) {
                        $opnom='ENE'.$anno;
                        $periodo = 'ENERO '.$anno;
                    }elseif ($mes==2) {
                        $opnom='FEB'.$anno;
                        $periodo = 'FEBRERO '.$anno;
                    }elseif ($mes==3) {
                        $opnom='MAR'.$anno;
                        $periodo = 'MARZO '.$anno;
                    }elseif ($mes==4) {
                        $opnom='ABR'.$anno;
                        $periodo = 'ABRIL '.$anno;
                    }elseif ($mes==5) {
                        $opnom='MAY'.$anno;
                        $periodo = 'MAYO '.$anno;
                    }elseif ($mes==6) {
                        $opnom='JUN'.$anno;
                        $periodo = 'JUNIO '.$anno;
                    }elseif ($mes==7) {
                        $opnom='JUL'.$anno;
                        $periodo = 'JULIO '.$anno;
                    }elseif ($mes==8) {
                        $opnom='AGO'.$anno; 
                        $periodo = 'AGOSTO '.$anno;
                    }elseif ($mes==9) {
                        $opnom='SEP'.$anno; 
                        $periodo = 'SEPTIEMBRE '.$anno;
                    }elseif ($mes==10) {
                        $opnom='OCT'.$anno;
                        $periodo = 'OCTUBRE '.$anno;
                    }elseif ($mes==11) {
                        $opnom='NOV'.$anno;
                        $periodo = 'NOVIEMBRE '.$anno;
                    }elseif ($mes==12) {
                        $opnom='DIC'.$anno;
                        $periodo = 'DICIEMBRE '.$anno;
                    }else{
                        $opnom=$anno;
                    }
                    //dd($opnom);
                    $detalles=DB::table('histo_nom_detconcep')->distinct()->where('id_trab','=',$dato->id_trab)
                                                            ->where('cod_docum','LIKE','%'.$opnom.'%')
                                                            ->where('concepto.su_int','=','S')
                                                            ->where('mov_nom.cod_nom','=',$tipoNomina)                             
                                                            ->join('concepto','concepto.cod_conc','histo_nom_detconcep.cod_concep')
                                                            ->join('mov_nom','mov_nom.cod_docu','histo_nom_detconcep.cod_docum')
                                                            ->select('histo_nom_detconcep.cod_concep','concepto.descripcion','mov_nom.tipo_nom', 
                                                                    DB::raw('sum(histo_nom_detconcep.asignacion) as total_a'), 
                                                                    DB::raw('sum(histo_nom_detconcep.deduccion) as total_d'))
                                                            ->groupBy('histo_nom_detconcep.cod_concep','concepto.descripcion','mov_nom.tipo_nom')
                                                            ->get();
                            $subtotal_a=0;
                            $subtotal_d=0;
                            $total=0;
                            foreach ($detalles as $detalle) {
                               $subtotal_a=$subtotal_a+($detalle->total_a*1);
                               $subtotal_d=$subtotal_d+($detalle->total_d*1);
                            }
                            $total=$subtotal_a-$subtotal_d;
                            $letras=NumeroALetras::convertir($total, 'Bolivares');
                            $footer['subtotal_a']= $subtotal_a;
                            $footer['subtotal_d']= $subtotal_d;
                            $footer['total']= $total;
                            $footer['letras']= $letras;
                            $footer['periodo']=$periodo;
                    if(count($detalles)>0){
                        $pdf = \PDF::loadView("pdf.const_integral",compact("dato","nomina","cargoconstancia","fec_ing","detalles","footer"));
                        return $pdf->stream('download.pdf');
                        //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing,'detalles' =>$detalles,'footer' =>$footer]);
                        exit;
                    }
                $mes=$mes-1;
                }
            $anno=$anno-1;
            $mes=12;
            }
                return response()->json(['error' => 'No hay Nominas registradas']);
            }
        }
        if (($tn=="AN")) {
        $datoAN=Perso_enomina::where('id_trab','=', $idTrabajador)
                                            ->join('cargos','cargos.cod_clase','perso_enomina.cod_cargo')
                                            ->select('perso_enomina.*','cargos.descripcion as cargo')
                                            ->first();
        $cargoconstancia=$datoAN->cargo;
        $fec_ing=date('d/m/Y', strtotime($datoAN->fech_ingre));
           if ($tipoConstancia=="1") {
                $pdf = \PDF::loadView("pdf.const_base",compact("dato","nomina","cargoconstancia","fec_ing"));
                return $pdf->stream('download.pdf');
                //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing]);  
            }elseif ($tipoConstancia=="2") {
                $sb=$datoAN->suel_altoniv;
                $letras=NumeroALetras::convertir($sb, 'Bolivares');
                $pdf = \PDF::loadView("pdf.const_sb",compact("dato","nomina","cargoconstancia","fec_ing","sb","letras"));
                return $pdf->stream('download.pdf');
                //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing,'sb' =>$sb,'letras' => $letras]);
            }elseif ($tipoConstancia=="3") {
            $annoant=$anno-1;
            while($anno>=$annoant){
                while($mes>=1) {
                   if ($mes==1) {
                        $opnom='ENE'.$anno;
                        $periodo = 'ENERO '.$anno;
                    }elseif ($mes==2) {
                        $opnom='FEB'.$anno;
                        $periodo = 'FEBRERO '.$anno;
                    }elseif ($mes==3) {
                        $opnom='MAR'.$anno;
                        $periodo = 'MARZO '.$anno;
                    }elseif ($mes==4) {
                        $opnom='ABR'.$anno;
                        $periodo = 'ABRIL '.$anno;
                    }elseif ($mes==5) {
                        $opnom='MAY'.$anno;
                        $periodo = 'MAYO '.$anno;
                    }elseif ($mes==6) {
                        $opnom='JUN'.$anno;
                        $periodo = 'JUNIO '.$anno;
                    }elseif ($mes==7) {
                        $opnom='JUL'.$anno;
                        $periodo = 'JULIO '.$anno;
                    }elseif ($mes==8) {
                        $opnom='AGO'.$anno; 
                        $periodo = 'AGOSTO '.$anno;
                    }elseif ($mes==9) {
                        $opnom='SEP'.$anno; 
                        $periodo = 'SEPTIEMBRE '.$anno;
                    }elseif ($mes==10) {
                        $opnom='OCT'.$anno;
                        $periodo = 'OCTUBRE '.$anno;
                    }elseif ($mes==11) {
                        $opnom='NOV'.$anno;
                        $periodo = 'NOVIEMBRE '.$anno;
                    }elseif ($mes==12) {
                        $opnom='DIC'.$anno;
                        $periodo = 'DICIEMBRE '.$anno;
                    }else{
                        $opnom=$anno;
                    }
                    //dd($opnom);
                    $detalles=DB::table('histo_nom_detconcep')->distinct()->where('id_trab','=',$dato->id_trab)
                                                            ->where('cod_docum','LIKE','%'.$opnom.'%')
                                                            ->where('concepto.su_int','=','S')
                                                            ->where('mov_nom.cod_nom','=',$tipoNomina)                             
                                                            ->join('concepto','concepto.cod_conc','histo_nom_detconcep.cod_concep')
                                                            ->join('mov_nom','mov_nom.cod_docu','histo_nom_detconcep.cod_docum')
                                                            ->select('histo_nom_detconcep.cod_concep','concepto.descripcion','mov_nom.cod_nom', 
                                                                    DB::raw('sum(histo_nom_detconcep.asignacion) as total_a'), 
                                                                    DB::raw('sum(histo_nom_detconcep.deduccion) as total_d'))
                                                            ->groupBy('histo_nom_detconcep.cod_concep','concepto.descripcion','mov_nom.cod_nom')
                                                            ->get();
                            $subtotal_a=0;
                            $subtotal_d=0;
                            $total=0;
                            foreach ($detalles as $detalle) {
                               $subtotal_a=$subtotal_a+($detalle->total_a*1);
                               $subtotal_d=$subtotal_d+($detalle->total_d*1);
                            }
                            $total=$subtotal_a-$subtotal_d;
                            $letras=NumeroALetras::convertir($total, 'Bolivares');
                            $footer['subtotal_a']= $subtotal_a;
                            $footer['subtotal_d']= $subtotal_d;
                            $footer['total']= $total;
                            $footer['letras']= $letras;
                            $footer['periodo']=$periodo;
                    if(count($detalles)>0){
                         $pdf = \PDF::loadView("pdf.const_integral",compact("dato","nomina","cargoconstancia","fec_ing","detalles","footer"));
                        return $pdf->stream('download.pdf');
                        //return response()->json(['dato' => $dato, 'nomina' =>$nomina,'cargoconstancia' =>$cargoconstancia,'fec_ing' =>$fec_ing,'detalles' =>$detalles,'footer' =>$footer]);
                        exit;
                    }
                $mes=$mes-1;
                }
            $anno=$anno-1;
            $mes=12;
            }
                return response()->json(['error' => 'No hay Nominas registradas']);
            }
        }
        }
    ///////////////////////////////////////////////
    public function imprimirari($idTrabajador,$anno){
        //$anno=2019;
        //$idTrabajador=8043;
        $annoactual=Carbon::now()->format('Y');
        $mesactual=Carbon::now()->format('m');
        $diaactual=Carbon::now()->format('d');
        $fecha=$anno."-".$mesactual."-".$diaactual;
        $lapse['start'] = Carbon::parse($fecha)->startOfYear(); 
        $lapse['end'] = Carbon::parse($fecha)->addYears()->startOfYear()->subDays(1);
    
            $dato=Datosgenerale::where('id_trab','=', $idTrabajador)
                                    ->where('status','=', 'ACTIVO')
                                    ->join('dependencias','dependencias.iddp','datosgenerales.iddepen')
                                    ->join('nominas','nominas.id','datosgenerales.id_nomina')
                                    ->join('cargos','cargos.cod_clase','datosgenerales.cod_cargo')
                                    ->join('formapago','formapago.id','datosgenerales.idformapago')
                                    ->join('banco','banco.cod_banco','datosgenerales.idbanco')
                                    ->select('datosgenerales.*','dependencias.nombre as dependencia','dependencias.responsable as jeferrhh','nominas.denominacion','cargos.descripcion as cargo','formapago.descripcion as formap','banco.nombre as banco')
                                    ->firstOrFail();
             if ($anno==$annoactual) {
                 $llego=$mesactual-1;
             }else{
                $llego=12;
             }
             $mes=1;
             $total=0;
             $totad=0;
             while ($mes <= $llego) {
                        if ($mes==1) {
                            $opnom='ENE'.$anno;
                            $periodo = 'ENERO ';
                        }elseif ($mes==2) {
                            $opnom='FEB'.$anno;
                            $periodo = 'FEBRERO ';
                        }elseif ($mes==3) {
                            $opnom='MAR'.$anno;
                            $periodo = 'MARZO ';
                        }elseif ($mes==4) {
                            $opnom='ABR'.$anno;
                            $periodo = 'ABRIL ';
                        }elseif ($mes==5) {
                            $opnom='MAY'.$anno;
                            $periodo = 'MAYO ';
                        }elseif ($mes==6) {
                            $opnom='JUN'.$anno;
                            $periodo = 'JUNIO ';
                        }elseif ($mes==7) {
                            $opnom='JUL'.$anno;
                            $periodo = 'JULIO ';
                        }elseif ($mes==8) {
                            $opnom='AGO'.$anno; 
                            $periodo = 'AGOSTO ';
                        }elseif ($mes==9) {
                            $opnom='SEP'.$anno; 
                            $periodo = 'SEPTIEMBRE ';
                        }elseif ($mes==10) {
                            $opnom='OCT'.$anno;
                            $periodo = 'OCTUBRE ';
                        }elseif ($mes==11) {
                            $opnom='NOV'.$anno;
                            $periodo = 'NOVIEMBRE ';
                        }elseif ($mes==12) {
                            $opnom='DIC'.$anno;
                            $periodo = 'DICIEMBRE ';
                        }else{
                            $opnom=$anno;
                        }
                $gerencials=DB::table('gerencials')->where('id', '=', 1)->first();
                $deducciones=DB::table('histo_nom_detconcep as dhc')->distinct()
                                ->join('concepto as con', 'dhc.cod_concep', '=', 'con.cod_conc')
                                ->select('dhc.cod_concep', 'con.descrip_corta', 
                                                DB::raw('sum(dhc.deduccion) as total_d'))
                                ->where('dhc.id_trab', '=', $idTrabajador)
                                ->where('dhc.cod_docum','LIKE','%'.$anno.'%') 
                                ->where('con.acc','=','DL')
                                ->groupBy('dhc.cod_concep', 'con.descrip_corta') 
                                ->get(); 
                
                $detalles=DB::table('histo_nom_detconcep')->distinct()->where('id_trab','=',$idTrabajador)
                                                                ->where('cod_docum','LIKE','%'.$opnom.'%')                           
                                                                ->select('histo_nom_detconcep.cod_concep', 
                                                                        DB::raw('sum(histo_nom_detconcep.asignacion) as total_a'), 
                                                                        DB::raw('sum(histo_nom_detconcep.deduccion) as total_d'))
                                                                ->groupBy('histo_nom_detconcep.cod_concep')
                                                                ->get();
             //return response()->json(['detalles' => $detalles]);
                                $subtotal_a=0;
                                $subtotal_d=0;
                                $totalmes=0;
                                foreach ($detalles as $detalle) {
                                   $subtotal_a=$subtotal_a+($detalle->total_a*1);
                                   $subtotal_d=$subtotal_d+($detalle->total_d*1);
                                }
                                $totalmes=$subtotal_a-$subtotal_d;
                                $total=$total+$totalmes;
                                $letras=NumeroALetras::convertir($total, 'Bolivares');
                                $fila=$mes-1;
                                $arrayARI[$fila]['mes']=$periodo;
                                $arrayARI[$fila]['remuneracion']=$totalmes;
                                $arrayARI[$fila]['porcret']=0;
                                $arrayARI[$fila]['impret']=0;
                                $arrayARI[$fila]['remacumulada']=$total;
                                $arrayARI[$fila]['impacumulado']=0;
                $mes=$mes+1;
             }
             
                        if(count($arrayARI)>0){
                            $datostrab=$dato;
                            $pdf = \PDF::loadView("pdf.ari",compact("datostrab","arrayARI","deducciones","anno","lapse","gerencials"));
                            return $pdf->stream('download.pdf');
                            //return response()->json(['datostrab' => $dato, 'arrayARI' =>$arrayARI,'deducciones' => $deducciones,'anno' =>$anno,'lapse' =>$lapse,'gerencials' =>$gerencials]);
                        }else{
                             return response()->json(['error' => 'No hay Nominas registradas']);
                        }
        }
    /////////////////////////////////////////////////////////////////////////////////
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}