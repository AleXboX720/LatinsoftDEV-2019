<?php

namespace App\Listeners\Servicios;

use App\Events\Servicios\Iniciados;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

use App\Modelos\Servicio;

class IniciadosListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Iniciados $event)
    {
        $listado = $event->listado;
        return $this->_procesarServicios($listado->toArray());

    }


    private function _procesarServicios($listado)
    {
        $servicios_iniciados = [];
        $servicios_finalizados = [];

        $serv_anter = null;
        foreach ($listado as $servicio) {
            if(!$servicio['iniciado']){
                if(Carbon::now()->getTimestamp() > $servicio['inic_servi']){                    
                    $servicio['iniciado'] = true;
                    $servicio['habilitado'] = false;   

                    array_push($servicios_iniciados, $servicio);                 
                }
            }
            if(!$servicio['finalizado']){
                if(Carbon::now()->getTimestamp() > $servicio['term_servi']){                    
                    $servicio['finalizado'] = true;

                    array_push($servicios_finalizados, $servicio); 
                }
            }
            
            \DB::beginTransaction();
            try{
                Servicio::where('codi_servi', $servicio['codi_servi'])
                        ->where('codi_circu', $servicio['codi_circu'])
                        ->where('nume_movil', $servicio['nume_movil'])
                        ->where('codi_equip', $servicio['codi_equip'])
                        ->update(
                         [
                            'iniciado'      => $servicio['iniciado'],
                            'finalizado'    => $servicio['finalizado'],
                            'habilitado'    => $servicio['habilitado'],
                            'serv_anter'    => $serv_anter
                        ]);

                $serv_anter = $servicio['codi_servi'];
            } catch (\Exception $e){
                \DB::rollback();
                //return response('Algo salio mal...!!!', 500);
            }
            \DB::commit();
        }
        
        return 
        [
            'iniciados' => $servicios_iniciados, 
            'finalizados' => $servicios_finalizados
        ];
    }
}
