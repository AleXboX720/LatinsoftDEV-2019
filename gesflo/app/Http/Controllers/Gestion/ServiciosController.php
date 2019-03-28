<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Vistas\ViewServicios;

use App\Modelos\Vistas\ViewListarProgramadas;
use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Vistas\ViewListarConductores;

use App\Modelos\Servicio;
use App\Modelos\Expedicion;
use App\Modelos\Programada;
use App\Modelos\Multa;
use App\Modelos\Pago;

use App\Modelos\Movil;


use App\Http\Controllers\Imprimir\ServiciosController as ImprimirServicio;

class ServiciosController extends Controller
{
    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Gestion',
            'subtitle'  => 'Servicios',
            'buscare'   => 'movi_busca',
            'lstCircuitos'   => $this::listadoCircuitos()
        ];
        return view('servicios.vista', compact('data'));
    }
	
    public function store(Request $request)
    {
        if($request->ajax())
        {			
			$servicio       = $request->servicio;
			$conductor      = $request->conductor;
			$movil          = $request->movil;
			$programadas    = $request->programadas;			
			
            $expediciones = $this->_definirExpediciones($programadas, $servicio['docu_perso'], $servicio['pate_movil'], $servicio['nume_movil']); 
            
			$imprimir    = $request->imprimir;

			\DB::beginTransaction();
            try
            {                
                Servicio::_crear($servicio);
                foreach($programadas as $programada){
                    Programada::_crear($programada);
                }
                foreach($expediciones as $expedicion){
                    Expedicion::_crear($expedicion);
                }
                $movil['docu_condu'] = $servicio['codi_licen'];
                $movil['ulti_servi'] = $servicio['codi_servi'];
                Movil::_actualizar($movil);
                
                $mensaje = 'Nota: Servicio Registrado Correctamente.';
                return response()->json([
                    'msg' => $mensaje
                ], 200);
            } catch (\Exception $e){
                \DB::rollback();
                return response('Algo salio mal...!!!', 500);
            } finally {
				if($imprimir === "true"){
					$boleta_pagar = new ImprimirServicio;
					$boleta_pagar->imprimirVouche($servicio, $programadas, $conductor, $movil);
				}
            }
            \DB::commit();
        }
    }

    private function _definirExpediciones($programadas, $docu_perso, $pate_movil, $nume_movil)
    {
        $expediciones = [];
        $inic_exped = null;
        $elSentido = null;
        foreach($programadas as $obj){
            if($elSentido !== $obj['codi_senti']){
                $inic_exped = null;
                $elSentido = $obj['codi_senti'];
            }
            if($inic_exped == null){
                $inic_exped = $obj['fech_progr'];
            }
            $term_exped = $obj['fech_progr'];

            $expediciones[$obj['codi_senti']] = [
                'codi_servi' => $obj['codi_servi'],
                'codi_circu' => $obj['codi_circu'],
                'codi_senti' => $obj['codi_senti'],
                'docu_empre' => $this->_docu_empre,
                'docu_perso' => $docu_perso,
                'pate_movil' => $pate_movil,
                'nume_movil' => $nume_movil,
                'inic_exped' => date('Y-m-d H:i:s', $inic_exped),
                'term_exped' => date('Y-m-d H:i:s', $term_exped)
            ];
        }
        return $expediciones;
    }

    public function actualizarServicio(Request $request)
    {
        if($request->ajax()){
            $servicios = $request->listado;
            try
            {
                foreach ($servicios as $servicio) {
                    Servicio::where('codi_servi', $servicio['codi_servi'])
                            ->where('codi_circu', $servicio['codi_circu'])
                            ->where('nume_movil', $servicio['nume_movil'])
                            ->where('codi_equip', $servicio['codi_equip'])
                            ->update(
                             [
                                'iniciado'      => $servicio['iniciado'],
                                'finalizado'    => $servicio['finalizado'],
                                'habilitado'    => $servicio['habilitado'],
                                'procesar'      => $servicio['procesar'],
                                'serv_anter'    => $servicio['serv_anter']
                            ]);
                }            

                $mensaje = '<b>Nota: </b>Servicio Actualizado Correctamente.';
                return response()->json([
                    'msg' => $mensaje, 
                    'clr' => 'alert-danger'
                ], 200);
            } catch (\Exception $e){
                    return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function eliminarServicio(Request $request)
    {
        if($request->ajax()){
            $codi_servi = $request->codi_servi;
            $codi_circu = $request->codi_circu;

            try
            {
                $objServicio = Servicio::
                        where('codi_servi', $codi_servi)->
                        where('codi_circu', $codi_circu)->
                        delete();

                $objExpediciones = Expedicion::
                        where('codi_servi', $codi_servi)->
                        where('codi_circu', $codi_circu)->
                        delete();

                $objProgramadas =  Programada::
                        where('codi_servi', $codi_servi)->
                        where('codi_circu', $codi_circu)->
                        delete();

                $objMultas = Multa::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            //where('nume_movil', $nume_movil])->
                            delete();

                $objPagos = Pago::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            //where('nume_movil', $nume_movil])->
                            delete();

                $mensaje = 'El Servicio se ha Eliminado Correctamente.';
                return response()->json([
                    'msg' => $mensaje
                ], 200);
            }
            catch (\Exception $e) 
            {
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function listarServicios(Request $request)
    {
        if($request->ajax())
        {
            $codi_circu = $request->codi_circu;
            $fech_servi = $request->fech_servi;
            try
            {            
                $desde = strtotime('+0 day', strtotime($fech_servi));
                $hasta = strtotime('+1 day', strtotime($fech_servi));
                
                $lst =  $this->_losServicios($codi_circu, $desde, $hasta, 'DESC');

                if($lst->count() > 0){
                    $mensaje = 'Se encontraron ' .$lst->count(). ' Servicios.';
                    return response()->json([
                            'listado'   => $lst->toArray(),
                            'procesar'  => true, 
                            'total'     => $lst->count(),
                            'msg'       => $mensaje
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios para el "Dia" Seleccionado.', 404);
                }
    
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function finalizarServicios(Request $request)
    {
        if($request->ajax())
        {
            $codi_circu = $request->codi_circu;
            $fech_servi = $request->fech_servi;
            try
            {            
                $desde = strtotime('+0 day', strtotime($fech_servi));
                $hasta = strtotime('+1 day', strtotime($fech_servi));

                $lst =  $this->_losServicios($codi_circu, $desde, $hasta, 'DESC');

                if($lst->count() > 0){
                    $listados = $this->_analizarServicios($codi_circu, $desde, $hasta);
                    //$lst_iniciados = $listados[0]['iniciados'];
                    $lst_finalizados = $listados[0]['finalizados'];

                    $mensaje = 'Hay: ' .count($lst_finalizados). ' Servicios que han Finalizados.';
                    return response()->json([
                            //'iniciados'     => $lst_iniciados,
                            'finalizados'   => $lst_finalizados,
                            //'total_iniciados'     => count($lst_iniciados),
                            'total'   => count($lst_finalizados),
                            'msg'           => $mensaje
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios para Procesar.', 404);
                }
    
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function procesarServicio(Request $request)
    {
        if($request->ajax())
        {
            $codi_circu = $request->codi_circu;
            $fech_servi = $request->fech_servi;
            $nume_movil = $request->nume_movil;
            try
            {            
                $desde = strtotime('+0 day', strtotime($fech_servi));
                $hasta = strtotime('+1 day', strtotime($fech_servi));
                $desde = date('Y-m-d H:i:s', $desde);
                $hasta = date('Y-m-d H:i:s', $hasta);

                //$lst = ViewServicios::_listar($codi_circu, $this->_docu_empre, $desde, $hasta);

                $lst = ViewServicios::_procesarServicio($codi_circu, $nume_movil, $desde, $hasta, 'ASC');
                if($lst->count() > 0){
                    $mensaje = 'Hay: ' .$lst->count(). ' Servicios por Procesar.';
                    return response()->json([
                            'listado'   => $lst->toArray(),
                            'procesar'  => true, 
                            'total'     => $lst->count(),
                            'msg'           => $mensaje
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios para Procesar.', 404);
                }
    
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }
    public function procesarServicios(Request $request)
    {
        if($request->ajax())
        {
            $codi_circu = $request->codi_circu;
            $fech_servi = $request->fech_servi;
            try
            {            
                $desde = strtotime('+0 day', strtotime($fech_servi));
                $hasta = strtotime('+1 day', strtotime($fech_servi));
                $desde = date('Y-m-d H:i:s', $desde);
                $hasta = date('Y-m-d H:i:s', $hasta);

                //$lst = ViewServicios::_listar($codi_circu, $this->_docu_empre, $desde, $hasta);

                $lst = ViewServicios::_procesar($codi_circu, $desde, $hasta, 'ASC');
                if($lst->count() > 0){
                    $mensaje = 'Hay: ' .$lst->count(). ' Servicios por Procesar.';
                    return response()->json([
                            'listado'   => $lst->toArray(),
                            'procesar'  => true, 
                            'total'     => $lst->count(),
                            'msg'           => $mensaje
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios para Procesar.', 404);
                }
    
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }
    
    public function buscarServicio(Request $request)
    {
        if($request->ajax()){
            $codi_servi = $request->codi_servi;
            $codi_circu = $request->codi_circu;

            try{
                $mi_servicio = ViewServicios::
                            where('codi_servi', $codi_servi)->
    						where('codi_circu', $codi_circu)->
                            limit(1)->
    						get();
                $mis_expediciones = Expedicion::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            get();
                $mis_controladas =  ViewListarProgramadas::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            groupBy('fech_progr')->
                            get();
                $mis_multas = Multa::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            get();
                /*SERVICIO ANTERIOR*/
                $serv_anter = $mi_servicio[0]['serv_anter'];
                $tu_servicio = null;
                $tus_expediciones = null;
                $tus_controladas = null;
                $tus_multas = null;
                if($serv_anter != null){
                    $tu_servicio = 
                    [
                        'servicio'      => ViewServicios::
                            where('codi_servi', $serv_anter)->
                            where('codi_circu', $codi_circu)->
                            limit(1)->
                            get()->toArray()[0],
                        'expediciones'  => Expedicion::
                            where('codi_servi', $serv_anter)->
                            where('codi_circu', $codi_circu)->
                            get(),
                        'controladas'   => ViewListarProgramadas::
                            where('codi_servi', $serv_anter)->
                            where('codi_circu', $codi_circu)->
                            groupBy('fech_progr')->
                            get(),
                        'multas'        => Multa::
                            where('codi_servi', $serv_anter)->
                            where('codi_circu', $codi_circu)->
                            get(),
                    ];
                }

                if($mi_servicio->count() > 0){
                    $multado = false;
                    if($mis_multas->count() > 0){
                        $multado = true;
                    }
                    $mensaje = 'Nota: Servicio "COD: '.$codi_servi. '" Encontrado Correctamente.';
                    return response()->json([
                        //'msg'           => $mensaje, 
                        'mi_servicio'  => [
                            'servicio'   => $mi_servicio[0], 
                            'expediciones'  => $mis_expediciones, 
                            'controladas'   => $mis_controladas, 
                            'multas'        => $mis_multas,
                        ],
                        'tu_servicio'   => $tu_servicio, 
                        //'multado'       => $multado
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios con el "COD: '.$codi_servi. '"', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function serviciosPendientes(Request $request)
    {
        try{
            $codi_circu = $request->codi_circu;
            $nume_movil = $request->nume_movil;
            $pate_movil = $request->pate_movil;
            $fech_servi = $request->fech_servi;

            $desde = strtotime('+0 day', strtotime($fech_servi));
            $hasta = strtotime('+1 day', strtotime($fech_servi));
            $desde = date('Y-m-d H:i:s', $desde);
            $hasta = date('Y-m-d H:i:s', $hasta);


            $servicio = Servicio::
                        where('codi_circu', $codi_circu)
                        ->where('nume_movil', $nume_movil)
                        ->where('pate_movil', $pate_movil)
                        ->whereBetween('inic_servi', [$desde, $hasta])
                        ->where('finalizado', 0)
                        ->limit(1)
                        ->get();

            $pendientes = false;
            if($servicio->count() > 0){
                $pendientes = true;
            }
            return response()->json([
                'pendientes'    => $pendientes,
                'msg'           => 'Movil con Servicios Pendientes. No se puede generar este servcio.'
            ], 200);                
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }

	public function existeServicio(Request $request)
    {
        if($request->ajax()){
            $codi_servi = $request->codi_servi;
            $codi_circu = $request->codi_circu;

            try{
                $servicio = Servicio::
                            where('codi_servi', $codi_servi)
                            ->where('codi_circu', $codi_circu)
                            ->limit(1)
                            ->get();

                $existe = false;
                if($servicio->count() > 0){
					$existe = true;
                }
				return response()->json([
					'existe'   => $existe,
                    'msg'       => 'Ya Existe un Servicio en este Horario. No se puede generar este servcio.'
                ], 200); 			
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    /*DISPARAR EVENTO PARA PROCESAR SERVICIOS MASIVAMENTE*/
    private function _analizarServicios($codi_circu, $desde, $hasta)
    {
        $lst = $this->_losServicios($codi_circu, $desde, $hasta, 'ASC');
        return event(new \App\Events\Servicios\Analizar($lst));
    }

    private function _verificarServiciosIniciados($codi_circu, $desde, $hasta)
    {
        $lst = $this->_losServicios($codi_circu, $desde, $hasta, 'ASC');
        return event(new \App\Events\Servicios\Analizar($lst));
    }

    private function _verificarServiciosFinalizados($lst)
    {
        //$lst = $this->_losServicios($codi_circu, $desde, $hasta, 'DESC');
        event(new \App\Events\Servicios\Finalizados($lst));
    }

    private function _verificarServiciosProcesar($codi_circu, $desde, $hasta)
    {
        $lst = $this->_losServicios($codi_circu, $desde, $hasta, 'ASC');
        event(new \App\Events\Servicios\Procesar($lst));
    }

    private function _losServicios($codi_circu, $desde, $hasta, $orden)
    {
        $desde = date('Y-m-d H:i:s', $desde);
        $hasta = date('Y-m-d H:i:s', $hasta);  
        return ViewServicios::where('codi_circu', $codi_circu)
            ->where('docu_empre', $this->_docu_empre)
            ->whereBetween('inic_servi', [$desde, $hasta])
            ->orderBy('inic_servi', $orden)
            ->get();
    }
    /*##################################################*/
    public function buscarMovil(Request $request)
    {
        if($request->ajax())
        {
            $nume_movil = $request->nume_movil;
            try{
                $movil = ViewListarMoviles::where('nume_movil', $nume_movil)
                    ->where('docu_empre', $this->_docu_empre)
                    ->limit(1)
                    ->get();

                if($movil->count() > 0){
                    $dias = $this->_diferenciasEntreFecha($movil[0]->fech_revis);
                    $mensaje = 'Nota: Movil "N°: '.$nume_movil. '" Encontrado Correctamente.';
                    return response()->json([
                        'msg'   => $mensaje, 
                        'movil' => $movil->toArray(), 
                        'total' => $movil->count(),
                        'dias'  => $dias + 1,
                        'clr'   => 'alert-info'
                    ], 200);
                } else {
                    return response('Nota: No se Encontro el Movil "N°: '.$nume_movil. '"', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function buscarConductor(Request $request)
    {
        if($request->ajax())
        {
            $codi_licen = $request->codi_licen;
            try{
                $conductor = ViewListarConductores::where('codi_licen', $codi_licen)
                    ->where('docu_empre', $this->_docu_empre)
                    ->limit(1)
                    ->get();
                    
                $mensaje = '<b>Nota: </b>Conductor Encontrado Exitosamente.';

                if($conductor->count() > 0){
                    $dias = $this->_diferenciasEntreFecha($conductor[0]->fech_venci);
                    $mensaje = 'Nota: Conductor "COD: '.$codi_licen. '" Encontrado Correctamente.';
                    return response()->json([
                        'msg'       => $mensaje, 
                        'conductor' => $conductor->toArray(), 
                        'total'     => $conductor->count(),
                        'dias'      => $dias + 1,
                        'clr'       => 'alert-info'
                    ], 200);
                } else {
                    return response('Nota: No se Encontro el Conductor "COD: '.$codi_licen. '"', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    private function _diferenciasEntreFecha($fech_revis)
    {
        $fech_actua = new \DateTime("now");
        $fech_revis = new \DateTime($fech_revis);
        $diferencia = $fech_revis->diff($fech_actua);
        $diferencia = ($diferencia->invert <= 0) ? ($diferencia->days * -1) : $diferencia->days;
        return $diferencia;
    }

    public function filtrarServicios(Request $request)
    {
        if($request->ajax())
        {
            try
            {
                $nume_movil = $request->nume_movil;
                $lst = ViewServicios::where('nume_movil', $nume_movil)
                        ->where('codi_circu', $request->codi_circu)
                        ->where('docu_empre', $this->_docu_empre)
                        ->whereBetween('codi_servi', 
                        [
                                strtotime('+0 day' , strtotime($request->fech_servi)), 
                                strtotime('+1 day' , strtotime($request->fech_servi))
                        ])
                        ->orderBy('inic_servi', 'ASC')
                        ->get();

                if($lst->count() > 0){
                    $mensaje = 'Se encontraron ' .$lst->count(). ' Servicios.';
                    return response()->json([
                            'listado'   => $lst->toArray(),
                            'total'     => $lst->count(),
                            'msg'       => $mensaje
                    
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios para el "Movil" Seleccionado.', 404);
                }
                
            } catch (\Exception $e){
                    return response('Algo salio mal...!!!', 500);
            }
        }
    }
}