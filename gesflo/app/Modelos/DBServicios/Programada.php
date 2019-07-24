<?php

namespace App\Modelos\DBServicios;

use App\Modelos\DBServicios\Configuracion as Model;

//-----------------------------------
use Carbon\Carbon;
class Programada extends Model
{
	protected $table = 'tb_programadas';
	protected $primaryKey = 'codi_servi';
	protected $relations = ['tb_servicios'];
	protected $fillable = [
							'codi_servi', 'codi_circu', 'nume_movil', 'codi_ruta', 'codi_senti', 'codi_geoce', 
							'fech_progr', 'fech_contr', 'minu_toler','dife_contro', 'tota_multa', 
							'latitud', 'longitud', 'angulo', 'velo_contr', 'procesado', 'multado'
						];

	public static function _crear($programada)
    {
    	$obj = new Programada($programada);
    	Programada::create($obj->toArray());
	}

	public static function _actualizarProgramada($s, $c, $e, $g, $f, $lat, $lon, $h, $v, $d, $t, $m)
    {
        \DB::beginTransaction();
        try
        {
            $programada = Programada::
            where('codi_servi', $s)
            ->where('codi_circu', $c)
            ->where('codi_senti', $e)
            ->where('procesado', false)
            ->where('codi_geoce', $g);
            $programada->update(
            [
                'fech_contr' => Carbon::createFromTimestamp($f)->toDateTimeString(),
                'latitud'    => $lat,
                'longitud'   => $lon,
                'angulo' => $h,
                'velo_contr' => intval($v),
                'dife_contro'=> intval($d),
                'tota_multa' => $t,
                'procesado'  => true,
                'multado'    => $m
            ]);

        } catch (\Exception $e){
            \DB::rollback();
            return response('Algo salio mal...!!!', 500);
        }
        \DB::commit();
    }
}