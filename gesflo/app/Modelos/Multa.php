<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
	protected $connection = 'db_servicios';

	protected $table = 'tb_multas';
	protected $primaryKey = 'codi_servi';

	protected $fillable = [
		'codi_servi', 'codi_circu', 'nume_movil', 'codi_senti',   
		'tota_multa', 'fech_multa', 'tota_pagad', 'fech_pagad', 
		'pagada', 'user_modif'
	];

	protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
