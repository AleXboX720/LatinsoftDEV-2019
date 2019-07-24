<?php

namespace App\Modelos\DBGestra;

use App\Modelos\DBGestra\Configuracion as Model;

class ViewConductores extends Model
{
    protected $table = 'viewListarConductores';
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

	public static function _buscar($docu_empre, $codi_licen)
	{
		try
		{
			$conductor = ViewConductores::where('codi_licen', $codi_licen)
	            ->where('docu_empre', $docu_empre)
	            ->limit(1)
	            ->get();

	        return $conductor; 
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
	}

    public static function _listar($docu_empre)
    {
        try
        {
            $listado = ViewConductores::where('docu_empre', $docu_empre)
                ->orderBy('apel_pater')
                ->get();

            return $listado; 
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }
	
    public static function _filtrar($docu_empre, $apel_pater)
    {
        try{
            $listado = ViewConductores::where('apel_pater', 'LIKE', "%$apel_pater%")->where('docu_empre', $docu_empre)->get();
            
            return $listado;
        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }

	public function scopeSearch($query, $apel_pater){
		return $query->where('apel_pater', 'LIKE', "%$apel_pater%");
	}
}