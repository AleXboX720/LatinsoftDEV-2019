<?php

namespace App\Modelos\DBServicios;

use App\Modelos\DBServicios\Configuracion;

class Pago extends Configuracion
{
	protected $table = 'tb_pagos';
	protected $primaryKey = 'codi_servi';

	protected $fillable = [
		'codi_servi', 'codi_circu', 'nume_movil',  
		'tipo_pago', 'nota_pago', 'pago_total', 'desc_total',  'user_modif',
	];

	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	public static function _crear(Pago $obj)
	{
		try
        {
        	Pago::create($obj);
        } catch (\Exception $e){
            return response('Problemas al tratar de Crear: Pago', 500);
        }
	}

	public static definirPago($s, $c, $m, $t, $n, $p, $d, $u)
	{
	   	$pago['codi_servi'] = $s;
        $pago['codi_circu'] = $c;
        $pago['nume_movil'] = $m;

        $pago['tipo_pago' ] = $t;
        $pago['nota_pago' ] = $n;
        $pago['pago_total'] = $p;
        $pago['desc_total'] = $d;
        $pago['user_modif'] = $u;

        $this->_crear($multa);
	}
}
