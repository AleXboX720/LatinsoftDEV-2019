<?php

namespace App\Http\Responsables\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBServicios\ViewServicios;

class FrecuenciaServicios implements Responsable
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
        $data = 
        [
            'title'     => 'Frecuencia del Servicio',
            'subtitle'  => '',
            'codi_circu'=> $request->codi_circu,
            'listado'   => $this->_listarServicios($request),
        ];

        return view('monitores.vista', compact('data'));
    }

    private function _listarServicios($request)
    {
        $docu_empre = $request->docu_empre;
        $codi_circu = $request->codi_circu;
        $fech_servi = $request->fech_servi;

        $desde = strtotime(date('Y-m-d 00:00:00'));
        $hasta = strtotime(date('Y-m-d 23:59:59'));

        return ViewServicios::where('codi_circu', $codi_circu)
                    ->where('docu_empre', $docu_empre)
                    ->whereBetween('codi_servi', [$desde, $hasta])
                    ->limit(22)
                    ->get();
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