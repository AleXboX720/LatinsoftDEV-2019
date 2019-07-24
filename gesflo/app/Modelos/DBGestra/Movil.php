<?php

namespace App\Modelos\DBGestra;

use App\Modelos\DBGestra\Configuracion as Model;

class Movil extends Model
{
	protected $table = 'tb_moviles';
	protected $primaryKey = 'nume_movil';
	
	protected $fillable = [
		'nume_movil', 'pate_movil', 'docu_empre', 'docu_perso', 
		'ulti_servi', 'anio_movil', 'fech_revis', 'habilitado', 
		'docu_condu', 'codi_equip'
	];

	public static function _buscar($nume_movil)
	{
		try
		{
			return Movil::where('nume_movil', $nume_movil)->get();
		} catch (\Exception $e){
            \DB::rollback();
            return response('Error en el Servidor...!!!', 500);
        }
	}

	public static function _eliminar($nume_movil, $pate_movil)
	{
		try
		{
			Movil::where('nume_movil', $nume_movil)->where('pate_movil', $pate_movil)->delete();
		} catch (\Exception $e){
            \DB::rollback();
            return response('Error en el Servidor...!!!', 500);
        }
	}

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
