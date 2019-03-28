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

	public static function _actualizar($movil)
	{
        try
        {
			$obj = new Movil($movil);
			Movil::where('nume_movil', $obj->nume_movil)
	            ->where('pate_movil', $obj->pate_movil)
	            ->where('codi_equip', $obj->codi_equip)
	            ->where('nume_movil', $obj->nume_movil)
	            ->where('docu_empre', $obj->docu_empre)
	        ->update([
	            'docu_condu'    => $obj->docu_condu,
	            'ulti_servi'    => $obj->ulti_servi
	        ]);
        } catch (\Exception $e){
            return response('No se Encontro Programada...!!!', 500);
        }
	}
}
