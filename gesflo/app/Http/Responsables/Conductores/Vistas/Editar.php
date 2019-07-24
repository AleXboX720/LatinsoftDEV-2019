<?php

namespace App\Http\Responsables\Conductores\Vistas;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBGestra\Conductor;
use App\Modelos\DBGestra\Licencia;

use App\Modelos\DBLatinsoft\Persona;
use App\Modelos\DBLatinsoft\Domicilio;
use App\Modelos\DBLatinsoft\Contacto;


use App\Modelos\Nacionalidad;
use App\Modelos\ECivil;
use App\Modelos\Provincia;

class Editar implements Responsable
{
	protected $_docu_empre = '96711420';
    protected $_docu_perso;

	public function __construct($request)
	{
        $this->_docu_perso = $request->docu_perso;
	}

	public function toResponse($request)
	{
        $docu_empre = $this->_docu_empre;
        $docu_perso = $this->_docu_perso;
        $data = 
        [
            'title'             => 'Editar',
            'subtitle'          => 'Conductor',
            'lstNacionalidades' => Nacionalidad::_listar(),
            'lstECiviles'       => ECivil::_listar(),
            'lstProvincias'     => Provincia::_listar(),

            'objPersona'        => Persona::_buscar($docu_perso),
            'objDomicilio'      => Domicilio::_buscar($docu_perso),
            'objContacto'       => Contacto::_buscar($docu_perso),

            'objConductor'      => Conductor::_buscar($docu_perso),
            'objLicencia'       => Licencia::_buscar($docu_perso),
        ];
        return view('manager.conductores.edit.vista', compact('data'));
	}
}