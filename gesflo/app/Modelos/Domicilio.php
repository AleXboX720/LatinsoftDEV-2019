<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
	protected $connection = 'db_latinsoft';
	
	protected $table = 'tb_domicilios';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_personas', 'tb_ciudades'];
	protected $fillable = ['docu_perso', 'nomb_domic', 'nume_domic', 'nomb_pobla', 'nume_bloqu', 'nume_depto', 'idde_provi', 'idde_comun'];

	/*	RELACIONES	*/
	public function persona(){
		return $this->belongsTo('App\Modelos\Persona');
	}

	public function ciudad(){
		return $this->belongsTo('App\Modelos\Ciudad');
	}
}