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
							'latitud', 'longitud', 'angulo', 'velo_contr', 'procesado', 'multado'
						];

	public static function _crear($programada)
    {
    	$obj = new Programada($programada);
        Programada::create([
            'codi_servi' => $obj->codi_servi,
            'codi_circu' => $obj->codi_circu,
            'codi_senti' => $obj->codi_senti,
            'codi_ruta'  => $obj->codi_ruta,
            'codi_geoce' => $obj->codi_geoce,
            'minu_toler' => $obj->minu_toler,
            'fech_progr' => $obj->fech_progr,
            'nume_movil' => $obj->nume_movil
        ]);
	}
}