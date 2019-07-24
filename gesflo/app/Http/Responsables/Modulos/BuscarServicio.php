<?php

namespace App\Http\Responsables\Modulos;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBServicios\ViewServicios;


class BuscarServicio implements Responsable
{
	protected $_codi_circu;
	protected $_codi_servi;
	//protected $_nume_movil;
	//protected $_pate_movil;

	protected $_docu_empre = '96711420';

	public function __construct($request)
	{
		$this->_codi_circu = $request->codi_circu;
		$this->_codi_servi = $request->codi_servi;
		//$this->_nume_movil = $request->nume_movil;
		//$this->_pate_movil = $request->pate_movil;
	}

	public function toResponse($request)
	{
        $docu_empre = $this->_docu_empre;
		$codi_circu = $this->_codi_circu;
        $codi_servi = $this->_codi_servi;
		//$nume_movil = $this->_nume_movil;
		//$pate_movil = $this->_pate_movil;

        $servicio = ViewServicios::_buscar($docu_empre, $codi_circu, $codi_servi);
        if($servicio['total'] > 0){
        	$tu_servicio = null;
        	$mi_servicio = $servicio;
        	if($servicio['servicio']['serv_anter'] !== null){
                $servicio = ViewServicios::_buscar($docu_empre, $codi_circu, $servicio['servicio']['serv_anter']);
                //$servicio = $objeto['servicio'];
                $tu_servicio = $servicio; 
            }
            $el_objeto['mi_servicio'] = $mi_servicio;
        	$el_objeto['tu_servicio'] = $tu_servicio;

			return response($el_objeto, 200);
        } else {
            return response('No se Encontro el Servicio Seleccionado.', 404);
        }
	}
}