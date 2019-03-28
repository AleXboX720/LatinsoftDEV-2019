<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Circuito extends Model
{
	protected $connection = 'db_gestra';
	protected $table = 'tb_circuitos';
	protected $primaryKey = 'docu_empre';
	protected $relations = ['db_servicios'];
	protected $fillable = [
							'docu_empre', 'codi_circu', 'nomb_circu', 'abre_circu', 'unid_negoc'
						];

	/*	RELACIONES	*/
	public function servicios(){
		return $this->hasMany('App\Modelos\Servicio');
	}
}
