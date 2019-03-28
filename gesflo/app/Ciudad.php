<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
	protected $connection = 'db_gestra';
	protected $table = 'tb_ciudades';
	protected $primaryKey = 'idde_ciuda';
	protected $relations = ['tb_domicilios', 'tb_provincias'];
	protected $fillable = ['idde_ciuda', 'idde_provi', 'nomb_ciuda', 'abre_ciuda'];

	/*	RELACIONES	*/
	public function domicilio(){
		return $this->belongsTo('App\Modelos\Domicilio');
	}

	public function provincia(){
		return $this->belongsTo('App\Modelos\Provincia');
	}
}