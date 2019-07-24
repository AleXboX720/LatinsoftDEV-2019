<?php

namespace App\Http\Responsables\Conductores;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Input;

use App\Modelos\DBGestra\Conductor;
use App\Modelos\DBGestra\Licencia;

use App\Modelos\DBLatinsoft\Persona;
use App\Modelos\DBLatinsoft\Domicilio;
use App\Modelos\DBLatinsoft\Contacto;

class Actualizar implements Responsable
{
	protected $_docu_empre = '96711420';

	public function __construct($request)
	{        
    }

	public function toResponse($request)
	{
        try
        {
            $this->_actualizarPersona(input::all());
            $this->_actualizarLicencia(input::all());
            $this->_actualizarCondutor(input::all());
            $this->_actualizarDomicilio(input::all());
            $this->_actualizarContacto(input::all());
            $msg = 'Conductor Actualizado Correctamente';
            return response()->json([
                            'msg' => $msg
                    ], 200);
        } catch (\Exception $e){
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
	}

    private function _actualizarCondutor($request)
    {
        \DB::beginTransaction();
        try
        {
            $conductor = new Conductor($request);
            Conductor::where('docu_perso', $request['docu_perso'])->update($conductor->toArray());
        } catch (\Exception $e){
            \DB::rollback();
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
        \DB::commit();
    }

    private function _actualizarLicencia($request)
    {
        \DB::beginTransaction();
        try
        {
            $licencia = new Licencia($request);
            Licencia::where('docu_perso', $request['docu_perso'])->update($licencia->toArray());
        } catch (\Exception $e){
            \DB::rollback();
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
        \DB::commit();
    }

    private function _actualizarPersona($request)
    {
        \DB::beginTransaction();
        try
        {
            $persona = new Persona($request);
            Persona::where('docu_perso', $request['docu_perso'])->update($persona->toArray());
        } catch (\Exception $e){
            \DB::rollback();
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
        \DB::commit();
    }

    private function _actualizarDomicilio($request)
    {
        \DB::beginTransaction();
        try
        {
            $domicilio = new Domicilio($request);
            Domicilio::where('docu_perso', $request['docu_perso'])->update($domicilio->toArray());
        } catch (\Exception $e){
            \DB::rollback();
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
        \DB::commit();
    }

    private function _actualizarContacto($request)
    {
        \DB::beginTransaction();
        try
        {
            $contacto = new Contacto($request);
            Contacto::where('docu_perso', $request['docu_perso'])->update($contacto->toArray());
        } catch (\Exception $e){
            \DB::rollback();
            return response('No se Logro Actualizar el Conductor...!!', 500);
        }
        \DB::commit();
    }
}