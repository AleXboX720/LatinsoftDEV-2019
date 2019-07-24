<?php

namespace App\Modelos\DBGestra;

use App\Modelos\DBGestra\Configuracion as Model;

class Propietario extends Model
{	
	protected $table = 'tb_propietarios';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_moviles', 'tb_persona'];
	protected $fillable = [
		'docu_empre', 'docu_perso', 'vinculado'
	];

	public static function _buscar($docu_perso)
	{
		try
		{
			return Propietario::where('docu_perso', $docu_perso)->get();
		} catch (\Exception $e){
            \DB::rollback();
            return response('Error en el Servidor...!!!', 500);
        }
	}

	public static function _eliminar($docu_perso, $docu_empre)
	{
		try
		{
			Propietario::where('docu_perso', $docu_perso)->where('docu_empre', $docu_empre)->delete();
		} catch (\Exception $e){
            \DB::rollback();
            return response('Error en el Servidor...!!!', 500);
        }
	}
	/*	RELACIONES	*/
	public function persona(){
		return $this->belongsTo('App\Modelos\Persona');
	}

	public function empresa(){
		return $this->belongsTo('App\Modelos\Empresa');
	}
	
	public function movil(){
		return $this->hasMany('App\Modelos\Movil');
	}
}
