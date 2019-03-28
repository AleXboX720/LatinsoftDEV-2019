<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
	protected $connection = 'db_servicios';
	protected $table = 'tb_servicios';
	protected $primaryKey = 'codi_servi';
	protected $relations = ['tb_expediciones', 'tb_circuitos'];
	protected $fillable = [
		'codi_servi', 'codi_circu', 'docu_empre', 'docu_perso', 'pate_movil', 'codi_equip', 
		'inic_servi', 'term_servi', 'nume_movil',  
		'iniciado', 'finalizado', 'habilitado', 'procesar',  'serv_anter', 
		'multado', 'tota_pagar', 'tota_pagad', 'user_modif'
	];

	/*	RELACIONES	*/
	public function expeciones(){
		return $this->hasMany('App\Modelos\Expedicion');
	}

	public function circuito(){
		return $this->belongsTo('App\Modelos\Circuito');
	}

	/* SCOPES */
	public function scopeProcesar($query){
        return $query->where('procesar', true);
    }
}
