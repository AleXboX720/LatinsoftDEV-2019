<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
	protected $connection = 'db_latinsoft';
	
	protected $table = 'tb_contactos';
	protected $primaryKey = 'docu_perso';
	protected $relations = ['tb_personas'];
	protected $fillable = ['idde_conta', 'docu_perso', 'tele_conta', 'movi_conta', 'mail_conta'];

	/*	RELACIONES	*/
	public function persona(){
		return $this->belongsTo('App\Modelos\Persona');
	}
}