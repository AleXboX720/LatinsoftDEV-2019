<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarConductores;

use App\Modelos\Persona;
use App\Modelos\Domicilio;
use App\Modelos\Contacto;
use App\Modelos\Conductor;
use App\Modelos\Licencia;

class ConductoresController extends Controller
{

    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Conductores',
            'buscare'   => 'apel_pater'
        ];
        return view('manager.conductores.vista', compact('back', 'data'));
    }

    public function create()
    {
        $data = 
        [
            'title'     => 'Crear',
            'subtitle'  => 'Conductor',
            'buscare'   => 'apel_pater',
            'lstNacionalidades' => $this::listadoNacionalidades(),
            'lstECiviles'       => $this::listadoECivil(),
            'lstProvincias'     => $this::listadoProvincias()
        ];         
        return view('manager.conductores.create.vista', compact('data'));
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

            Conductor::create($request->all());
            Licencia::create($request->all());
        }


        $mensaje = '<b>Nota: </b>Conductor Agregado Correctamente.';
        return response()->json([
            'msg' => $mensaje, 
            'clr' => 'alert-success'
        ]);
    }

    public function show(Request $request)
    {
		$conductor = ViewListarConductores::where('codi_licen', $request->codi_licen)
					->where('docu_empre', $this->_docu_empre)
                    ->limit(1)
					->get();

        $mensaje = '<b>Nota: </b>Conductor Encontrado Exitosamente.';
		
		return response()->json([
			'msg' => $mensaje, 
			'conductor' => $conductor->toArray()
		]);
    }
	
	public function listarConductores(Request $request)
    {
        if($request->ajax()){
			try{				
				$lst = ViewListarConductores::where('docu_empre', $this->_docu_empre)->get();
				
                if($lst->count() > 0){
                    return response()->json([
                            'listado' => $lst->toArray(),
                            'total' => $lst->count()
                    ], 200);
				} else {
                    return response()->json(['NO SE ENCONTRARON CONDUCTORES!!!'], 404);
                }
			} catch (\Exception $e){
				return response('Algo salio mal...!!!', 500);
			}
        }
    }
	
	public function filtrarConductor(Request $request)
    {        
        if($request->ajax()){
    		try{
    			$apel_pater = $request->apel_pater;
    			$lst = ViewListarConductores::where('apel_pater', 'LIKE', "%$apel_pater%")->where('docu_empre', $this->_docu_empre)->get();
    			
                if($lst->count() > 0){
                    return response()->json([
                            'listado' => $lst->toArray(),
                            'total' => $lst->count()
                    ], 200);
                } else {
                    return response()->json(['NO SE ENCONTRARON CONDUCTORES!!!'], 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function edit($docu_perso)
    {
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'Conductor',
            'lstNacionalidades' => $this::listadoNacionalidades(),
            'lstECiviles'       => $this::listadoECivil(),
            'lstProvincias'     => $this::listadoProvincias(),

            'objPersona'    => Persona::where('docu_perso', $docu_perso)->get()->all(),
            'objDomicilio'  => Domicilio::where('docu_perso', $docu_perso)->get(),
            'objContacto'   => Contacto::where('docu_perso', $docu_perso)->get(),

            'objConductor'  => Conductor::where('docu_perso', $docu_perso)->where('docu_empre', $this->_docu_empre)->get()->all(),
            'objLicencia'   => Licencia::where('docu_perso', $docu_perso)->get()->all()
        ];  
        return view('manager.conductores.edit.vista', compact('data')
        );
    }

    public function update(Request $request, $docu_perso)
    {
        if($request->ajax()){
            //Persona::find($docu_perso)->update($request->all());            
            Persona::find($docu_perso)->update([
                'prim_nombr' => strtoupper($request->prim_nombr),
                'segu_nombr' => strtoupper($request->segu_nombr),
                'apel_pater' => strtoupper($request->apel_pater),
                'apel_mater' => strtoupper($request->apel_mater),
                'idde_gener' => $request->idde_gener,
                'fech_nacim' => $request->fech_nacim,
                'idde_nacio' => $request->idde_nacio,
                'idde_ecivi' => $request->idde_ecivi,
            ]);
            Domicilio::find($docu_perso)->update($request->all());
            Contacto::find($docu_perso)->update($request->all());

            Conductor::find($docu_perso)->update($request->all());
            Licencia::find($docu_perso)->update($request->all());

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
            Conductor::find($docu_perso)->delete();
            Licencia::find($docu_perso)->delete();

            $mensaje = '<b>Nota: </b>Conductor Eliminado Correctamente.';
            return response()->json([
                'msg' => $mensaje, 
                'clr' => 'alert-success'
            ]);
        }
    }

	
}