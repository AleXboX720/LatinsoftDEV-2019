<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
	protected $connection = 'db_servicios';

	protected $table = 'tb_pagos';
	protected $primaryKey = 'codi_servi';

	protected $fillable = [
		'codi_servi', 'codi_circu', 'nume_movil',  
		'tipo_pago', 'nota_pago', 'pago_total', 'desc_total',  'user_modif',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];
}
