<?php

namespace App\Modelos\Vistas;

use Illuminate\Database\Eloquent\Model;

class ViewListarCircuitos extends Model
{
	protected $connection = 'db_gestra';
	
    protected $table = 'viewListarCircuitos';
	protected $primaryKey = 'docu_empre';
	
	protected $fillable = [
							'codi_circu', 'abre_circu', 'nomb_circu', 'unid_negoc',  
							'docu_empre', 'nomb_empre', 'domi_empre', 'tele_movil', 
							'mail_empre', 'habilitado'
						];
}