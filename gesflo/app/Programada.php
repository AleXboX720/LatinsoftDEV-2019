<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Programada extends Model
{
	protected $connection = 'db_servicios';
	protected $table = 'tb_programadas';
	protected $primaryKey = 'codi_servi';
	protected $relations = ['tb_servicios'];
	protected $fillable = [
							'codi_servi', 'codi_circu', 'nume_movil', 'codi_ruta', 'codi_senti', 'codi_geoce', 
							'fech_progr', 'fech_contr', 'minu_toler','dife_contro', 'tota_multa', 
							'latitud', 'longitud', 'grad_angul', 'velo_contr', 'procesado', 'multado'
						];

	
}