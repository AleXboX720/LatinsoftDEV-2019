<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
	protected $connection = 'db_latinsoft';
	
	protected $table = 'tb_provincias';
	protected $primaryKey = 'idde_provi';
	protected $relations = ['tb_comunas'];
	protected $fillable = ['idde_ciuda', 'nomb_provi', 'abre_provi', 'idde_pais'];

	/*	RELACIONES	*/
	public function comunas(){
		return $this->hasMany('App\Modelos\Comuna');
	}
	/*
	public function pais(){
		return $this->belongsTo('App\Modelos\Pais');
	}
	*/
}