<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewListarConductores extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'viewListarConductores';
	protected $primaryKey = 'docu_perso';
	//protected $relations = ['tb_personas', 'tb_domicilios', 'tb_contactos', 'tb_empresas', 'tb_tiposusuario', 'tb_ciudades'];
	//protected $dateFormat = 'yyyy-mm-dd hh:mm:ss';
	
	protected $fillable = [
							'docu_perso', 'prim_nombr', 'segu_nombr', 'apel_pater', 'apel_mater',
							'fech_nacim', 'idde_nacio', 'idde_ecivi', 'idde_gener',
							'idde_usuar', 'pass_usuar', 'habilitado', 'idde_tipo', 
							'nomb_tipo', 'abre_tipo', 'nomb_ciuda', 'nomb_domic', 
							'nume_domic', 'nomb_pobla', 'nume_bloqu', 'nume_depto',
							'idde_ciuda', 'tele_conta', 'movi_conta', 'mail_conta',
							'docu_empre', 'nomb_empre', 'idde_unego', 
							'codi_licen'
						];

	public function scopeSearch($query, $apel_pater){
		return $query->where('apel_pater', 'LIKE', "%$apel_pater%");
	}
}