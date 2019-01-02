<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
	protected $connection = 'db_gestra';
	
	protected $table = 'tb_propietarios';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_moviles', 'tb_persona'];
	protected $fillable = [
							'docu_empre', 'docu_perso', 'vinculado'
						];

	/*	RELACIONES	*/
	public function persona(){
		return $this->belongsTo('App\Modelos\Persona');
	}

	public function empresa(){
		return $this->belongsTo('App\Modelos\Empresa');
	}
	
	public function movil(){
		return $this->hasMany('App\Modelos\Movil');
	}
}
