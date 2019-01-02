<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Vistas\ViewListarServicios;
use App\Modelos\Vistas\ViewListarProgramadas;
use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Vistas\ViewListarConductores;

use App\Modelos\Servicio;
use App\Modelos\Expedicion;
use App\Modelos\Programada;
use App\Modelos\Multa;

use App\Modelos\Movil;


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
			$servicio       = $request->data['servicio'];
			$conductor      = $request->data['conductor'];
			$movil          = $request->data['movil'];
			$programadas    = $request->data['programadas'];
			
			
            $expediciones = $this->_definirExpediciones($programadas, $servicio['docu_perso'], $servicio['pate_movil'], $servicio['nume_movil']); 
            \DB::beginTransaction();

            try{
                $this->_salvarServicio($servicio);
                $this->_salvarMovil($movil, $servicio['codi_licen'], $servicio['codi_servi']);
                $this->_salvarProgramadas($programadas);
                $this->_salvarExpediciones($expediciones);
                $mensaje = 'Nota: Servicio Registrado Correctamente.';
                return response()->json([
                    'msg' => $mensaje
                ], 200);
            } catch (\Exception $e){
                \DB::rollback();
                return response('Algo salio mal...!!!', 500);
            } finally {
                //TODO : IMRPIMIR EL SERVICIO
                /*
                $servi = ViewListarServicios::where('codi_servi', $servicio['codi_servi'])
                    ->where('codi_circu', $servicio['codi_circu'])
                    ->where('nume_movil', $servicio['nume_movil'])
                    ->where('codi_equip', $servicio['codi_equip'])
                    ->get();
                event(new \App\Events\Servicios\Imprimir($servi, $programadas, $conductor, $movil));
                */
            }
            \DB::commit();
        }
    }

    private function _salvarServicio($servicio)
    {
        $obj = new Servicio($servicio);
        Servicio::create([
            'codi_servi' => $obj->codi_servi,
            'codi_circu' => $obj->codi_circu,
            'docu_empre' => $obj->docu_empre,
            'docu_perso' => $obj->docu_perso,
            'nume_movil' => $obj->nume_movil,
            'pate_movil' => $obj->pate_movil,
            'codi_equip' => $obj->codi_equip,
            'inic_servi' => date('Y-m-d H:i:s', $obj->inic_servi),
            'term_servi' => date('Y-m-d H:i:s', $obj->term_servi),
            'habilitado' => $obj->habilitado,
			'user_modif' => \Auth::user()->docu_perso
        ]);
    }

    private function _salvarMovil($movil, $codi_licen, $codi_servi)
    {
        $obj = new Movil($movil);
        Movil::where('nume_movil', $obj->nume_movil)
            ->where('pate_movil', $obj->pate_movil)
            ->where('codi_equip', $obj->codi_equip)
            ->where('nume_movil', $obj->nume_movil)
            ->where('docu_empre', $obj->docu_empre)
        ->update([
            'docu_condu'    => $codi_licen,
            'ulti_servi'    => $codi_servi
        ]);
    }

    private function _salvarProgramadas($programadas)
    {
        foreach($programadas as $programada){
            $obj = new Programada($programada);
            Programada::create([
                'codi_circu' => $obj->codi_circu,
                'codi_senti' => $obj->codi_senti,
                'codi_ruta'  => $obj->codi_ruta,
                'codi_geoce' => $obj->codi_geoce,
                'minu_toler' => $obj->minu_toler,
                'fech_progr' => date('Y-m-d H:i:s', $obj->fech_progr),
                'codi_servi' => $obj->codi_servi,
                'nume_movil' => $obj->nume_movil
            ]);
        }
    }

    private function _salvarExpediciones($expediciones)
    {
        foreach($expediciones as $expedicion){
            $obj = new Expedicion($expedicion);      
            Expedicion::create([
                'codi_servi' => $obj->codi_servi,
                'codi_circu' => $obj->codi_circu,
                'codi_senti' => $obj->codi_senti,
                'docu_empre' => $obj->docu_empre,
                'docu_perso' => $obj->docu_perso,
                'nume_movil' => $obj->nume_movil,
                'pate_movil' => $obj->pate_movil,
                'inic_exped' => $obj->inic_exped,
                'term_exped' => $obj->term_exped                
            ]);
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

                $lst =  ViewListarServicios::where('codi_circu', $codi_circu)
                            ->where('docu_empre', $this->_docu_empre)
                            ->where('procesar', true)
                            ->whereBetween('inic_servi', [$desde, $hasta])
                            ->orderBy('inic_servi', 'ASC')
                            ->get();

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
                $objServicio = ViewListarServicios::
                            where('codi_servi', $codi_servi)->
    						where('codi_circu', $codi_circu)->
    						get();

                $objExpediciones = Expedicion::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            get();

                $objProgramadas =  ViewListarProgramadas::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            get();

                $objMultas = Multa::
                            where('codi_servi', $codi_servi)->
                            where('codi_circu', $codi_circu)->
                            get();

                if($objServicio->count() > 0){
                    $multado = false;
                    if($objMultas->count() > 0){
                        $multado = true;
                    }
                    $mensaje = 'Nota: Servicio "COD: '.$codi_servi. '" Encontrado Correctamente.';
                    return response()->json([
                        'msg'           => $mensaje, 
                        'servicio'      => $objServicio, 
                        'expediciones'  => $objExpediciones, 
                        'controladas'   => $objProgramadas, 
                        'multas'        => $objMultas,
                        'multado'       => $multado,
                        'total'         => $objServicio->count(),
                        'clr'           => 'alert-info'
                    ], 200);
                } else {
                    return response('No se Encontraron Servicios con el "COD: '.$codi_servi. '"', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }
/*
    public function _tieneServiciosanteriores($codi_circu, $nume_movil, $pate_movil)
    {
        try{
            $servicio = ViewListarServicios::
                        where('codi_circu', $codi_circu)
                        ->where('nume_movil', $nume_movil)
                        ->where('pate_movil', $pate_movil)
                        ->where('finalizado', 0)
                        ->get();
            if($servicio->count() > 0){
                return true;                
            } else {
                return false;
            }
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }
*/
    public function serviciosPendientes(Request $request)
    {
        try{
            $codi_circu = $request->codi_circu;
            $nume_movil = $request->nume_movil;
            $pate_movil = $request->pate_movil;

            $servicio = Servicio::
                        where('codi_circu', $codi_circu)
                        ->where('nume_movil', $nume_movil)
                        ->where('pate_movil', $pate_movil)
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
        return ViewListarServicios::where('codi_circu', $codi_circu)
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
                    return response('Nota: No se Encontro el Conductor "COD: '.$nume_movil. '"', 404);
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
                $lst = ViewListarServicios::where('nume_movil', $nume_movil)
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