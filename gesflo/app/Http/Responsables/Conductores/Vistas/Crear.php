<?php

namespace App\Http\Responsables\Conductores\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\Nacionalidad;
use App\Modelos\ECivil;
use App\Modelos\Provincia;

class Crear implements Responsable
{
    protected $_docu_empre = '96711420';

    public function __construct()
    {
    }

    public function toResponse($request)
    {
        $data = 
        [
            'title'     => 'Crear',
            'subtitle'  => 'Conductor',
            'buscare'   => 'apel_pater',
            'lstNacionalidades' => Nacionalidad::_listar(),
            'lstECiviles'       => ECivil::_listar(),
            'lstProvincias'     => Provincia::_listar(),
        ];         
        return view('manager.conductores.create.vista', compact('data'));
    }
}