<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewMultasRecaudadas extends Model
{
	protected $connection = 'db_servicios';	
    protected $table = 'viewMultasRecaudadas';

    protected $fillable = [];

    public static function _listar($user_modif, $d, $h)
    {
        try
        {
            $listado = ViewMultasRecaudadas::where('user_modif', $user_modif)
                    ->whereBetween('codi_servi', [$d, $h])
                    //->orderBy('inic_servi', 'ASC')
                    ->get();

            return $listado;
        } catch (\Exception $e){
            return response('No se Encontro Multas...!!!', 500);
        }
    }
}