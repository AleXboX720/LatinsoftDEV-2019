<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'tb_conductores';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_personas', 'tb_empresas', 'tb_licencias'];
	protected $fillable = ['docu_perso', 'docu_empre', 'habilitado'];

	/*	RELACIONES	*/
	public function persona(){
		return $this->belongsTo('App\Modelos\Persona');
	}

	public function licencia(){
		return $this->belongsTo('App\Modelos\Licencia');
	}
    
}
