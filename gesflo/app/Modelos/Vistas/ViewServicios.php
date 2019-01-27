<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewServicios extends Model
{
	protected $connection = 'db_servicios';	
    protected $table = 'viewServicios';

    public static function _listar($c, $e, $d, $h)
	{
		try
        {
            $listado = ViewServicios::where('codi_circu', $c)
                    ->where('docu_empre', $e)
                    ->where('procesar', true)
                    ->whereBetween('inic_servi', [$d, $h])
                    ->orderBy('inic_servi', 'ASC')
                    ->get();

            return $listado;
        } catch (\Exception $e){
            return response('No se Encontro Programada...!!!', 500);
        }
	}

}