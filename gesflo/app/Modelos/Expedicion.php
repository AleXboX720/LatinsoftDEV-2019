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

    public static function _crear($expedicion)
    {
        try
        {
        	$obj = new Expedicion($expedicion);
            Expedicion::create([
                'codi_servi' => $obj->codi_servi,
                'codi_circu' => $obj->codi_circu,
                'codi_senti' => $obj->codi_senti,
                'docu_empre' => $obj->docu_empre,
                'docu_perso' => $obj->docu_perso,
                'nume_movil' => $obj->nume_movil,
                'pate_movil' => $obj->pate_movil,
                'inic_exped' => $obj->inic_exped,
                'term_exped' => $obj->term_exped                
            ]);
        } catch (\Exception $e){
            return response('No se Encontro Programada...!!!', 500);
        }
	}
}