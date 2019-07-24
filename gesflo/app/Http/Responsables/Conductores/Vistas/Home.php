<?php

namespace App\Http\Responsables\Conductores\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\Nacionalidad;
use App\Modelos\ECivil;
use App\Modelos\Provincia;

class Home implements Responsable
{

    public function __construct($request)
    {
    }

    public function toResponse($request)
    {
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Conductores',
            'buscare'   => 'apellido_buscar',
            'lstNacionalidades' => Nacionalidad::_listar(),
            'lstECiviles'       => ECivil::_listar(),
            'lstProvincias'     => Provincia::_listar(),
        ];
        return view('manager.conductores.vista', compact('back', 'data'));
    }
}