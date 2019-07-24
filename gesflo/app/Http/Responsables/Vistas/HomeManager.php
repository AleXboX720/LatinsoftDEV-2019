<?php

namespace App\Http\Responsables\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBServicios\ViewListarServicios;
use App\Modelos\DBGestra\ViewConductores;
use App\Modelos\DBGestra\ViewPropietarios;

use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Vistas\ViewListarDevices;

use App\Modelos\DBGestra\Movil;
use App\Modelos\DBGestra\Conductor;

use App\Modelos\DBServicios\Expedicion;

class HomeManager implements Responsable
{
    protected $_docu_empre = '96711420';
    protected $_accountID = 'lineas-anf';
    protected $_groupID = 'linea-104-anf';
    
    public function __construct($request)
    {
    }

    public function toResponse($request)
    { 
        $data = [
            'title'     => 'Manager',
            'subtitle'  => 'Sistema de Gestion',
            'modulos'   => $this->_losModulos()
        ];
        return view('manager.vista', compact('data'));
    }


    private function _losModulos()
    {
        $desde = strtotime(date('Y-m-d', strtotime('first day of this month')));
        $hasta = strtotime(date('Y-m-d', strtotime('last day of this month')));

        $desde = date('Y-m-d H:i:s', $desde);
        $hasta = date('Y-m-d H:i:s', $hasta);

        return array(
            [
                'title'  => 'Conductores',
                'icono' => 'fa fa-id-card fa-1x',
                'color' => 'bg-blue',
                'route' => 
                [
                    'add' => route('conductores.crear'),
                    'list'=> route('conductores.index')
                ],
                'total' => ViewConductores::where('docu_empre', $this->_docu_empre)->where('habilitado', true)->get()->count()
            ],
            [
                'title'  => 'Propietarios',
                'icono' => 'fa fa-users fa-1x',
                'color' => 'bg-red',
                'route' => 
                [
                    'add' => route('propietarios.create'),
                    'list'=> route('propietarios.index')
                ],
                'total' => ViewPropietarios::where('docu_empre', $this->_docu_empre)->get()->count()
            ],
            [
                'title'  => 'Moviles',
                'icono' => 'fa fa-bus fa-1x',
                'color' => 'bg-olive',
                'route' => 
                [
                    'add' => route('moviles.crear'),
                    'list'=> route('moviles.index')
                ],
                'total' => Movil::where('docu_empre', $this->_docu_empre)->get()->count()
            ],
            [
                'title'  => 'Servicios',
                'icono' => 'fa fa-tasks fa-1x',
                'color' => 'bg-navy',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> '#!'
                ],
                'total' => ViewListarServicios::where('docu_empre', $this->_docu_empre)
                ->whereBetween('inic_servi', [$desde, $hasta])
                ->get()->count()
            ],
            [
                'title'  => 'Expediciones',
                'icono' => 'fa fa-line-chart fa-1x',
                'color' => 'bg-teal',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> '#!'
                ],
                'total' => Expedicion::where('docu_empre', $this->_docu_empre)
                ->whereBetween('inic_exped', [$desde, $hasta])
                ->where('procesada', 0)->get()->count()
            ],
            [
                'title'  => 'Equipos',
                'icono' => 'fa fa-hdd-o fa-1x',
                'color' => 'bg-orange',
                'route' => 
                [
                    'add' => route('equipos.create'),
                    'list'=> route('equipos.index')
                ],
                'total' => ViewListarDevices::where('accountID', $this->_accountID)->where('groupID', $this->_groupID)->get()->count()
            ]
        );
    }
}