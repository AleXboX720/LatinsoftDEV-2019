<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewListarPropietarios extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'viewListarPropietarios';
	protected $primaryKey = 'docu_perso';
	
	protected $fillable = [
							'docu_perso', 'prim_nombr', 'segu_nombr', 'apel_pater', 'apel_mater', 'idde_gener', 'vinculado', 
							'nomb_domic', 'nume_domic', 'tele_conta', 'movi_conta', 'mail_conta'
						];

	public function scopeSearch($query, $docu_perso){
		return $query->where('docu_perso', 'LIKE', "%$docu_perso%");
	}
}