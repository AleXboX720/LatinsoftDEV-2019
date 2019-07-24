<?php

namespace App\Http\Responsables\Moviles\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBGestra\Movil;
use App\Modelos\DBGestra\ViewPropietarios;

class Editar implements Responsable
{
	protected $_docu_empre = '96711420';
    protected $_nume_movil;

	public function __construct($request)
	{
        $this->_nume_movil = $request->nume_movil;
	}

	public function toResponse($request)
	{
        $docu_empre = $this->_docu_empre;
        $nume_movil = $this->_nume_movil;
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'Movil',
            'movil'     => Movil::_buscar($nume_movil)[0],
            'listado'   => ViewPropietarios::_listar($docu_empre)
        ];

        return view('manager.moviles.edit.vista', compact('data'));
	}
}