<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
	protected $connection = 'db_latinsoft';
	protected $table = 'tb_nacionalidades';
	protected $primaryKey = 'idde_nacio';
	
	protected $fillable = [
		'idde_nacio', 'nomb_nacio', 'abre_nacio'
	];

	public static function _listar()
    {
        try
        {
            $listado = Nacionalidad::orderBy('nomb_nacio', 'ASC')
                ->pluck('nomb_nacio', 'idde_nacio')
                ->all();

            return $listado; 
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }
}