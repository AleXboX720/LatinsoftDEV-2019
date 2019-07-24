<?php

namespace App\Modelos\DBGestra;

use App\Modelos\DBGestra\Configuracion;

class ViewMoviles extends Configuracion
{
    protected $table = 'viewListarMoviles';
	protected $primaryKey = 'nume_movil';
	
	protected $fillable = [
							'docu_empre', 'nume_movil', 'nume_devic', 'pate_movil', 'fech_revis', 'anio_movil', 
							'docu_perso', 'propietario', 'imei_equip', 'nume_telef', 'habilitado',
							'docu_condu'
						];

	public static function _buscar($docu_empre, $nume_movil)
	{
		try
		{
			$movil = ViewMoviles::where('nume_movil', $nume_movil)
	            ->where('docu_empre', $docu_empre)
	            ->limit(1)
	            ->get();
			return $movil;
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
	}

	public function scopeSearch($query, $pate_movil)
	{
		return $query->where('pate_movil', 'LIKE', "%$pate_movil%");
	}
}