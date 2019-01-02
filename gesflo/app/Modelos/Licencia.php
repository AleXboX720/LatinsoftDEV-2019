<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'tb_licencias';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_conductores'];
	protected $fillable = ['docu_perso', 'codi_licen', 'A1', 'A2', 'A3', 'A4', 'A5', 'B', 'C', 'D', 'E', 'F', 'fech_venci'];
	protected $casts = ['A1' => 'boolean', 'A2' => 'boolean', 'A3' => 'boolean', 'A4' => 'boolean', 'A5' => 'boolean', 'B' => 'boolean', 'C' => 'boolean', 'D' => 'boolean', 'E' => 'boolean', 'F' => 'boolean'];

	/*	RELACIONES	*/
	public function conductor(){
		return $this->belongsTo('App\Modelos\Conductor');
	}    
}
