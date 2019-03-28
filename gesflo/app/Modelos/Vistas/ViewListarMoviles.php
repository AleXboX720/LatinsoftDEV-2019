<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewListarMoviles extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'viewListarMoviles';
	protected $primaryKey = 'nume_movil';
	
	protected $fillable = [
							'docu_empre', 'nume_movil', 'nume_devic', 'pate_movil', 'fech_revis', 'anio_movil', 
							'docu_perso', 'propietario', 'imei_equip', 'nume_telef', 'habilitado',
							'docu_condu'
						];

	public function scopeSearch($query, $pate_movil){
		return $query->where('pate_movil', 'LIKE', "%$pate_movil%");
	}
}