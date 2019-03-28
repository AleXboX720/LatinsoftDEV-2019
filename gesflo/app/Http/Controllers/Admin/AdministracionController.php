<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarGeozonas;

use App\Modelos\Empresa;
use App\Modelos\Simcard;
use App\Modelos\Circuito;
use App\Modelos\Ruta;
use App\User;


class AdministracionController extends Controller
{

    public function index()
    {
        $data = [
            'title'     => 'Administracion',
            'subtitle'  => 'Sistema General',
            'modulos'   => $this->_losModulos()
        ];
    	return view('administrador.vista', compact('data'));
    }


    private function _losModulos()
    {
        return array(
            [
                'title'  => 'Empresas',
                'icono' => 'fa fa-bank fa-1x',
                'color' => 'bg-orange',
                'route' => 
                [
                    'add' => route('empresas.create'),
                    'list'=> route('empresas.index')
                ],
                'total' => Empresa::get()->count()
            ],
            [
                'title'  => 'Usuarios',
                'icono' => 'fa fa-user-circle-o fa-1x',
                'color' => 'bg-aqua',
                'route' => 
                [
                    'add' => route('usuarios.create'),
                    'list'=> route('usuarios.index')
                ],
                'total' => User::get()->count()
            ],
            [
                'title'  => 'Chips',
                'icono' => 'fa fa-microchip fa-1x',
                'color' => 'bg-teal',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> '#!'
                ],
                'total' => Simcard::where('docu_empre', $this->_docu_empre)->get()->count()
            ],
            [
                'title'  => 'Circuitos',
                'icono' => 'fa fa-map-o fa-1x',
                'color' => 'bg-gray',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> route('circuitos.index')
                ],
                'total' => Circuito::get()->count()
            ],
            [
                'title'  => 'Rutas',
                'icono' => 'fa fa-map-signs fa-1x',
                'color' => 'bg-info',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> route('rutas.index')
                ],
                'total' => Ruta::where('docu_empre', $this->_docu_empre)->get()->count()
            ],
            [
                'title'  => 'GeoZonas',
                'icono' => 'fa fa-crosshairs fa-1x',
                'color' => 'bg-success',
                'route' => 
                [
                    'add' => '#!',
                    'list'=> route('geozonas.index')

                ],
                'total' => ViewListarGeozonas::get()->count()
            ] 
        );
    }
}