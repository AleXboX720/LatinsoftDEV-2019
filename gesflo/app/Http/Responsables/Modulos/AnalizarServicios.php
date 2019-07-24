<?php

namespace App\Http\Responsables\Modulos;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBServicios\ViewServicios;

class AnalizarServicios implements Responsable
{
	protected $_codi_circu;
	protected $_fech_servi;

	protected $_docu_empre = '96711420';

	public function __construct($request)
	{
		$this->_codi_circu = $request->codi_circu;
		$this->_fech_servi = $request->fech_servi;
	}

	public function toResponse($request)
	{
        $docu_empre = $this->_docu_empre;
		$codi_circu = $this->_codi_circu;
		$desde = $this->_desde($this->_fech_servi);
		$hasta = $this->_hasta($this->_fech_servi);

        $listado = ViewServicios::_listarServiciosProcesar($docu_empre, $codi_circu, $desde, $hasta, 'ASC');

        if($listado->count() > 0){

        	event(new \App\Events\Servicios\Analizar($listado));
        	
            $mensaje = 'Se encontraron ' .$listado->count(). ' Servicios.';
            return response()->json([
                    'servicios'   => $listado->toArray(),
                    'procesar'  => true, 
                    'total'     => $listado->count(),
                    'msg'       => $mensaje
            ], 200);
        } else {
            return response('No se Encontraron Servicios para Procesar.', 404);
        }
	}

	

	private function _desde($fecha)
	{
		$desde = strtotime('+0 day', strtotime($fecha));
		$desde = date('Y-m-d H:i:s', $desde);
		return $desde;
	}

	private function _hasta($fecha)
	{
		$hasta = strtotime('+1 day', strtotime($fecha));
		$hasta = date('Y-m-d H:i:s', $hasta);
		return $hasta;
	}
}