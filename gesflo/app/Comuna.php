<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
	protected $connection = 'db_latinsoft';
	protected $table = 'tb_comunas';
	protected $primaryKey = 'idde_comun';
	protected $relations = ['tb_provincias', 'tb_domicilios'];
	protected $fillable = ['idde_comun', 'idde_provi', 'nomb_comun', 'abre_comun'];

	/*	RELACIONES	*/
	public function domicilio(){
		return $this->belongsTo('App\Modelos\Domicilio');
	}

	public function provincia(){
		return $this->belongsTo('App\Modelos\Provincia');
	}
}