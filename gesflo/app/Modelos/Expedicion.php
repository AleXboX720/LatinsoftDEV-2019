<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Expedicion extends Model
{
	protected $connection = 'db_servicios';
	protected $table = 'tb_expediciones';
	protected $primaryKey = 'codi_servi';
	protected $relations = ['db_servicios'];
	protected $fillable = [
							'codi_servi', 'codi_circu', 'codi_senti', 'docu_empre', 'docu_perso', 
							'pate_movil', 'nume_movil', 'inic_exped', 'term_exped'
						];
	protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}