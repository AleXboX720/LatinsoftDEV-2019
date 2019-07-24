<?php

namespace App\Http\Responsables\Modulos;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBServicios\ViewServicios;
use App\Modelos\Vistas\ViewArribos;

use App\Http\Controllers\Gestion\ProgramadasController;
class ProcesarServicios implements Responsable
{
	protected $_codi_servi;
    protected $_codi_circu;
    protected $_nume_movil;
    protected $_pate_movil;
    protected $_codi_equip;

	protected $_docu_empre = '96711420';

	public function __construct($request)
	{
        $this->_codi_servi = $request->codi_servi;
        $this->_codi_circu = $request->codi_circu;
        $this->_nume_movil = $request->nume_movil;
        $this->_pate_movil = $request->pate_movil;
        $this->_codi_equip = $request->codi_equip;
	}

	public function toResponse($request)
	{
        $codi_servi = $this->_codi_servi;
        $codi_circu = $this->_codi_circu;
        //$nume_movil = $this->_nume_movil;
        //$pate_movil = $this->_pate_movil;
        //$codi_equip = $this->_codi_equip;

        $docu_empre = $this->_docu_empre;

		$objeto = ViewServicios::_buscar($docu_empre, $codi_circu, $codi_servi);
        $servicio = $objeto['servicio'];
        $expediciones = $objeto['expediciones'];
        $this->_procesarExpediciones($servicio, $expediciones);       
	}

	private function _procesarExpediciones($servicio, $expediciones)
	{
		$codi_equip = $servicio['codi_equip'];
		$listado = $this->_listarArribos($expediciones, $codi_equip);
        foreach($listado as $lista)
        {            
            $codi_senti = $lista['sentido'];
            $controladas = $lista['arribos'];
            $this->_procesarProgramadas($servicio, $controladas, $codi_senti);
        }
        //IMPRIMIR INFORME DEL SERVICIO
	}

	private function _listarArribos($expediciones, $codi_equip)
	{
		$listado = null;
        foreach($expediciones as $expedicion)
        {
            $desde = strtotime ( '-10 minutes' , strtotime($expedicion['inic_exped']));
            $hasta = strtotime ( '+40 minutes' , strtotime($expedicion['term_exped']));

            $arribos = ViewArribos::_listar($codi_equip, $desde, $hasta);
            if($arribos->count() > 0)
            {
	            $listado[$expedicion['codi_senti']] = 
	            [
	                'sentido' => $expedicion['codi_senti'],
	                'arribos'=> $arribos->toArray()
	            ];            	
            }
        }
        return $listado;
	}
	
	private function _procesarProgramadas($servicio, $controladas, $codi_senti)
    {
        $programadas = new ProgramadasController;
        $programadas->procesarProgramadas($servicio, $controladas, $codi_senti);
    }
    /*------------------------------------------------------------------------------------------------------------------------------*/

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