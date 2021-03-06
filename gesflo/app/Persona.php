<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
	protected $connection = 'db_latinsoft';
	
	protected $table = 'tb_personas';
	protected $primaryKey = 'docu_perso';
	//protected $dateFormat = 'yyyy-mm-dd hh:mm:ss';
	protected $relations = ['tb_usuarios', 'tb_conductores', 'tb_propietarios', 'tb_domicilios', 'tb_contactos'];
	
	protected $fillable = ['docu_perso', 'prim_nombr', 'segu_nombr', 'apel_pater', 'apel_mater', 'idde_gener', 'fech_nacim', 'idde_nacio', 'idde_ecivi'];
	
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