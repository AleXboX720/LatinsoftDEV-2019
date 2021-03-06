<?php

namespace App\Listeners\Servicios;

use App\Events\Servicios\Analizar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;

use App\Modelos\Servicio;

class AnalizarListener
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
    public function handle(Analizar $event)
    {
        $listado = $event->listado;
        return $this->_analizarServicios($listado->toArray());

    }


    private function _analizarServicios($listado)
    {
        $minutos = 60 * 10;
        $servicios_iniciados = [];
        $servicios_finalizados = [];

        $serv_anter = null;
        foreach ($listado as $servicio){
            if(!$servicio['iniciado']){
                if(Carbon::now()->getTimestamp() > strtotime($servicio['inic_servi'])){                    
                    $servicio['iniciado'] = true;
                    $servicio['habilitado'] = false;   

                    array_push($servicios_iniciados, $servicio);                 
                }
            }
            
            if(!$servicio['finalizado']){
                if(Carbon::now()->getTimestamp() > (strtotime($servicio['term_servi']) + $minutos))
                {
                    $servicio['finalizado'] = true;
                    $servicio['procesar'] = true;

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
                            'procesar'      => $servicio['procesar'],
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
