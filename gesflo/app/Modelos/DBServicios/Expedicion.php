<?php

namespace App\Modelos\DBServicios;

use App\Modelos\DBServicios\Configuracion as Model;

class Expedicion extends Model
{
	protected $table = 'tb_expediciones';
	protected $primaryKey = 'codi_servi';
	protected $relations = ['tb_servicios'];
	protected $fillable = [
							'codi_servi', 'codi_circu', 'codi_senti', 'pate_movil', 'nume_movil', 
							'docu_empre', 'docu_perso', 'inic_exped', 'term_exped', 
							'iniciada', 'terminada', 'procesada'
						];

	public static function _crear($expedicion)
    {
    	$obj = new Expedicion($expedicion);
    	Expedicion::create($obj->toArray());
	}
}