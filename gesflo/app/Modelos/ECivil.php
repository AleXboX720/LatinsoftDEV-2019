<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ECivil extends Model
{
	protected $connection = 'db_latinsoft';
	protected $table = 'tb_estadosciviles';
	protected $primaryKey = 'idde_ecivi	';
	
	protected $fillable = [
							'idde_ecivi	', 'nomb_ecivi', 'abre_ecivi'
						];
}