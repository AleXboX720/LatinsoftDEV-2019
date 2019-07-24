<?php

namespace App\Http\Responsables\Conductores;

use Illuminate\Contracts\Support\Responsable;

use App\Modelos\DBGestra\Conductor;
use App\Modelos\DBGestra\Licencia;

use App\Modelos\DBLatinsoft\Persona;
use App\Modelos\DBLatinsoft\Domicilio;
use App\Modelos\DBLatinsoft\Contacto;

class Guardar implements Responsable
{
    protected $_docu_empre = '96711420';

    public function __construct()
    {
    }

    public function toResponse($request)
    {
        if(!$this->_existeConductor($request->all())){
            Conductor::create($request->all());
            Licencia::create($request->all());
            $objPersona = Persona::find($request->all());
            if (!$objPersona){
                Persona::create($request->all());
                Domicilio::create($request->all());
                Contacto::create($request->all());
            }

            $mensaje = 'Conductor Agregado Correctamente.';
            return response()->json([
                'msg' => $mensaje
            ], 200);
        }

        $mensaje = 'Este Conductor ya Existe en Nuestra Base de Datos.';
        return response()->json([
            'msg' => $mensaje
        ], 500);
    }

    /*--------------------------------------------------------------------------------------*/
    private function _existeConductor($request)
    {
        $existe = false;
        $docu_perso = $request['docu_perso'];
        $docu_empre = $this->_docu_empre;
        $conductor = Conductor::where('docu_perso', $docu_perso)
            ->where('docu_empre', $docu_empre)
            ->limit(1)
            ->get();
        if($conductor->count() > 0){
            $existe = true;
        }
        return $existe;
    }
}