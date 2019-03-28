<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Movil extends Model
{
	protected $connection = 'db_gestra';
	
	protected $table = 'tb_moviles';
	protected $primaryKey = 'nume_movil';
	
	protected $fillable = [
		'nume_movil', 'pate_movil', 'docu_empre', 'docu_perso', 
		'ulti_servi', 'anio_movil', 'fech_revis', 'habilitado', 
		'docu_condu', 'codi_equip'
	];

	/*	RELACIONES	*/
	public function propietario(){
		return $this->belongsTo('App\Modelos\Propietario');
	}
}
