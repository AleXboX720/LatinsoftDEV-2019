<?php

namespace App\Modelos\DBLatinsoft;

use App\Modelos\DBLatinsoft\Configuracion as Model;

class Persona extends Model
{	
	protected $table = 'tb_personas';
	protected $primaryKey = 'docu_perso';
	//protected $dateFormat = 'yyyy-mm-dd hh:mm:ss';
	protected $relations = ['tb_usuarios', 'tb_conductores', 'tb_propietarios', 'tb_domicilios', 'tb_contactos'];
	protected $fillable = ['docu_perso', 'prim_nombr', 'segu_nombr', 'apel_pater', 'apel_mater', 'idde_gener', 'fech_nacim', 'idde_nacio', 'idde_ecivi'];
	
	public static function _buscar($docu_perso)
	{
		$persona = Persona::where('docu_perso', $docu_perso)->get();
		return $persona;
	}
	/*	RELACIONES	*/
	public function usuarios(){
		return $this->hasMany('App\Modelos\Usuario');
	}

	public function conductor(){
		return $this->belongsTo('App\Modelos\Conductor');
	}

	public function propietario(){
		return $this->belongsTo('App\Modelos\Propietario');
	}

	public function domicilio(){
		return $this->belongsTo('App\Modelos\Domicilio');
	}

	public function contacto(){
		return $this->belongsTo('App\Modelos\Contacto');
	}

}