<?php

namespace App\Modelos\DBServicios;

use App\Modelos\DBServicios\Configuracion;

use App\Modelos\DBServicios\ViewProgramadas;
use App\Modelos\DBServicios\ViewExpediciones;
use App\Modelos\DBServicios\ViewMultasRecaudadas;

class ViewServicios extends Configuracion
{
    protected $table = 'viewServicios';
    protected $fillable = [
        'codi_servi', 'codi_circu', 'inic_servi', 'term_servi',
        'docu_empre', 'docu_perso', 'nume_movil', 'pate_movil', 
        'codi_equip', 'fech_revis', 
        'iniciado', 'finalizado', 'habilitado', 'procesar', 'serv_anter',   
        'multado', 'tota_pagar', 'tota_pagad'
        ,'dia'
    ];

    
    public static function _buscar($e, $c, $s)
    {
        try
        {
            $servicio = ViewServicios::where('codi_servi', $s)
                    ->where('codi_circu', $c)
                    ->where('docu_empre', $e)
                    ->limit(1)
                    ->get();
            $total = $servicio->count();

            $servicio = $servicio->toArray();
            $controladas    = ViewProgramadas::_listar($c, $s);
            $expediciones   = ViewExpediciones::_listar($c, $s);
            $multas         = ViewMultasRecaudadas::_listar($c, $s);
            return [
                'servicio'      => $servicio[0],
                'controladas'   => $controladas,
                'expediciones'  => $expediciones,
                'multas'        => $multas,
                'total'         => $total
            ];
        } catch (\Exception $e){
            return response('Error de Comunicacion en el Servidor!!!', 500);
        }
    }

    public static function _listar($e, $c, $d, $h, $o)
	{
		try
        {
            $listado = ViewServicios::where('codi_circu', $c)
                ->where('docu_empre', $e)
                ->whereBetween('inic_servi', [$d, $h])
                ->orderBy('inic_servi', $o)
                ->get();

            return $listado;
        } catch (\Exception $e){
            return response('Error de Comunicacion en el Servidor!!!', 500);
        }
	}

    public static function _filtrar($e, $c, $d, $h, $m, $o)
    {
        try
        {
            $listado = ViewServicios::where('codi_circu', $c)
                ->where('docu_empre', $e)
                ->where('nume_movil', $m)
                ->whereBetween('inic_servi', [$d, $h])
                ->orderBy('inic_servi', $o)
                ->get();

            return $listado;
        } catch (\Exception $e){
            return response('Error de Comunicacion en el Servidor!!!', 500);
        }
    }


    public static function _listarServiciosProcesar($e, $c, $d, $h, $o)
    {
        $listado = ViewServicios::where('codi_circu', $c)
            ->where('docu_empre', $e)
            ->whereBetween('inic_servi', [$d, $h])
            ->where('procesar', 'true')
            ->orderBy('inic_servi', $o)
            ->get();

        return $listado;
    }
}