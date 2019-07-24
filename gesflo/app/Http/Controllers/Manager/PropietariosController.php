<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\DBGestra\ViewPropietarios;
use App\Modelos\DBGestra\Propietario;

use App\Modelos\Persona;
use App\Modelos\Domicilio;
use App\Modelos\Contacto;
use App\Modelos\Movil;


class PropietariosController extends Controller
{
    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Propietarios',
            'buscare'   => 'apel_pater',
            'listado'   => ViewPropietarios::where('docu_empre', $this->_docu_empre)->paginate(11)
        ];
        return view('manager.propietarios.vista', compact('data'));
    }

    public function create()
    {
        $data = 
        [
            'title'     => 'Crear',
            'subtitle'  => 'Propietario',
            'buscare'   => 'apel_pater',
            'lstNacionalidades' => $this::listadoNacionalidades(),
            'lstECiviles'       => $this::listadoECivil(),
            'lstProvincias'     => $this::listadoProvincias()
        ]; 
        
        return view('manager.propietarios.create.vista', compact('data'));
    }

    public function store(Request $request)
    {
        if($request->ajax()){
            $objPersona = Persona::find($request->all());

            //if (!$objPersona){
            if (count($objPersona) === 0){
                Persona::create($request->all());
                Domicilio::create($request->all());
                Contacto::create($request->all());            
            }

            Propietario::create($request->all());
        }


        $mensaje = '<b>Nota: </b>Propietario Agregado Correctamente.';
        return response()->json([
            'msg' => $mensaje, 
            'clr' => 'alert-success'
        ]);
    }
    //TODO--->>>
    public function show(Request $request)
    {
        try{
            $propietario = ViewPropietarios::where('docu_perso', $request->docu_perso)
                    ->where('docu_empre', $this->_docu_empre)
                    ->get();            
            
            if(count($propietario) == 0){
                return response('NOTA: No Existe el Propietario', 404);
            } else {
                $mensaje = '<b>Nota: </b>Propietario Encontrado Exitosamente.';
                return response()->json([
                    'msg' => $mensaje, 
                    'propietario' => $propietario->toArray()
                ], 200);                
            }

        } catch (\Exception $e){
            return response('Algo salio mal...!!!', 500);
        }
    }
    //<<<---TODO

    public function listarPropietarios(Request $request)
    {
        if($request->ajax()){
            try{                
                $listado = ViewPropietarios::where('docu_empre', $this->_docu_empre)->get();
                if(!$listado){
                    return response()->json(['NO SE ENCONTRARON PROPIETARIOS!!!'], 404);
                } else {            
                    return response()->json($listado->toArray(), 200);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function filtrarPropietario(Request $request)
    {
        try{
            $apel_pater = $request->apel_pater;
            $listado = ViewPropietarios::where('apel_pater', 'LIKE', "%$apel_pater%")->where('docu_empre', $this->_docu_empre)->get();
            
            if(count($listado->toArray()) <= 0){
                return response()->json(['NO SE ENCONTRARON PROPIETARIOS!!!'], 404);
            } else {
                $mensaje = '<b>Nota: </b>Conductor Encontrado Correctamente.';
                return response()->json([
                    'listado' => $listado,
                    'msg' => $mensaje
                ], 200);
            }           
        } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
        }
    }
    public function edit($docu_perso)
    {
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'Propietario',
            'buscare'   => 'apel_pater',
            'lstNacionalidades' => $this::listadoNacionalidades(),
            'lstECiviles'       => $this::listadoECivil(),
            'lstProvincias'     => $this::listadoProvincias(),

            'objPersona'        => Persona::where('docu_perso', $docu_perso)->get()->all(),
            'objDomicilio'      => Domicilio::where('docu_perso', $docu_perso)->get(),
            'objContacto'       => Contacto::where('docu_perso', $docu_perso)->get(),

            'objPropietario' => Propietario::where('docu_perso', $docu_perso)->where('docu_empre', $this->_docu_empre)->get(),
            'objMoviles' => Movil::where('docu_perso', $docu_perso)->get()
        ];
        return view('manager.propietarios.edit.vista', compact('data'));
    }

    public function update(Request $request, $docu_perso)
    {
        if($request->ajax()){
            Persona::find($docu_perso)->update($request->all());
            Domicilio::find($docu_perso)->update($request->all());
            Contacto::find($docu_perso)->update($request->all());

            Propietario::find($docu_perso)->update($request->all());

            $mensaje = '<b>Nota: </b>Conductor Modificado Correctamente.';
            return response()->json([
                'msg' => $mensaje, 
                'clr' => 'alert-success'
            ]);
        }
    }

    public function destroy(Request $request, $docu_perso)
    {
        if($request->ajax()){
            $objPropietario = Propietario::find($docu_perso)->delete();

            $mensaje = '<b>Nota: </b>Propietario Eliminado Correctamente.';
            return response()->json([
                'msg' => $mensaje, 
                'clr' => 'alert-success'
            ]);
        }
    }
}
