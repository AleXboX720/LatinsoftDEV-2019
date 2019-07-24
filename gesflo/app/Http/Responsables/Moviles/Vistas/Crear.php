<?php

namespace App\Http\Responsables\Moviles\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBGestra\ViewPropietarios;

class Crear implements Responsable
{
    protected $_docu_empre = '96711420';

    public function __construct()
    {
    }

    public function toResponse($request)
    {
        $docu_empre = $this->_docu_empre;
        $data = 
        [
            'title'     => 'Crear',
            'subtitle'  => 'Movil',
            'buscare'   => 'pate_movil',
            'listado'   => ViewPropietarios::_listar($docu_empre)
        ];
        return view('manager.moviles.create.vista', compact('data'));
    }
}