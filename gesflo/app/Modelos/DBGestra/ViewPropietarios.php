<?php

namespace App\Modelos\DBGestra;

use App\Modelos\DBGestra\Configuracion as Model;

class ViewPropietarios extends Model
{	
    protected $table = 'viewListarPropietarios';
	protected $primaryKey = 'docu_perso';
	
	protected $fillable = [
		'docu_perso', 'prim_nombr', 'segu_nombr', 'apel_pater', 'apel_mater', 'idde_gener', 'vinculado', 
		'nomb_domic', 'nume_domic', 'tele_conta', 'movi_conta', 'mail_conta'
	];

	public static function _listar($docu_empre)
	{
		try
		{
			return ViewPropietarios::where('docu_empre', $docu_empre)->orderBy('apel_pater')->pluck('propietario', 'docu_perso')->all();
		} catch (\Exception $e){
            \DB::rollback();
            return response('Error en el Servidor...!!!', 500);
        }
	}

	public function scopeSearch($query, $docu_perso){
		return $query->where('docu_perso', 'LIKE', "%$docu_perso%");
	}
}