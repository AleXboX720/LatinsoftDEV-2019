<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
	protected $connection = 'db_servicios';
	
	protected $table = 'tb_rutas';
	protected $primaryKey = 'codi_ruta';
	//protected $relations = ['tb_equipos', 'tb_simcards', 'tb_propietario'];
	protected $fillable = [
							'codi_ruta', 'codi_circu', 'nomb_ruta', 'abre_ruta', 'codi_senti'
						];

	/*	RELACIONES	*/
	public function propietario(){
		return $this->belongsTo('App\Modelos\Propietario');
	}
}
