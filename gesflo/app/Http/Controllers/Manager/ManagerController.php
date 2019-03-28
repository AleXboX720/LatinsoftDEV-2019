<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarServicios;
use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Vistas\ViewListarConductores;
use App\Modelos\Vistas\ViewListarDevices;

use App\Modelos\Conductor;
use App\Modelos\Propietario;
use App\Modelos\Movil;
use App\Modelos\Expedicion;


class ManagerController extends Controller
{

    public function index()
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
                    'add' => route('conductores.create'),
                    'list'=> route('conductores.index')
                ],
                'total' => ViewListarConductores::where('docu_empre', $this->_docu_empre)->where('habilitado', true)->get()->count()
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
                'total' => Propietario::where('docu_empre', $this->_docu_empre)->get()->count()
            ],
            [
                'title'  => 'Moviles',
                'icono' => 'fa fa-bus fa-1x',
                'color' => 'bg-olive',
                'route' => 
                [
                    'add' => route('moviles.create'),
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