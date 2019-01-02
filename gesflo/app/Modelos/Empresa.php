<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	protected $connection = 'db_latinsoft';

	protected $table = 'tb_empresas';
	protected $primaryKey = 'docu_empre';
	//protected $relations = ['tb_usuarios'];

	protected $fillable = [
							'docu_empre', 'nomb_empre', 'domi_empre', 'tele_movil', 'mail_empre', 'habilitada', 'idde_unego' 
						];
}