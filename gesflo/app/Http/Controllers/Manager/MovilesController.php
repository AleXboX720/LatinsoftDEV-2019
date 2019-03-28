<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Vistas\ViewListarPropietarios;
use App\Modelos\Vistas\ViewListarServicios;

use App\Modelos\Movil;
use App\Modelos\Propietario;


class MovilesController extends Controller
{

    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Moviles',
            'buscare'   => 'pate_movil',
            'lstCircuitos'   => $this::listadoCircuitos()
        ];
        return view('manager.moviles.vista', compact('data'));
    }

    public function create()
    {
        $data = 
        [
            'title'     => 'Crear',
            'subtitle'  => 'Movil',
            'buscare'   => 'pate_movil',
            'listado'   => ViewListarPropietarios::where('docu_empre', $this->_docu_empre)->orderBy('apel_pater')->pluck('propietario', 'docu_perso')->all()
        ];
        return view('manager.moviles.create.vista', compact('data'));
    }

    public function store(Request $request)
    {
        if($request->ajax()){
            $movil = $request->nume_movil;
            $patente = $request->pate_movil;

            $objMovil = Movil::
                        where('nume_movil', $movil)->
                        where('pate_movil', $patente)->
                        where('docu_empre', $this->_docu_empre)->get();

            if (count($objMovil) === 0){
                Movil::create($request->all());

                $mensaje = '<b>Nota: </b>Movil Agregado Correctamente.';
                return response()->json([
                    'msg' => $mensaje, 
                    'clr' => 'alert-success'
                ]);
            }
        }
    }

    public function edit($nume_movil)
    {
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'Movil',
            'movil'     => Movil::find($nume_movil),
            'listado'   => ViewListarPropietarios::where('docu_empre', $this->_docu_empre)->orderBy('apel_pater')->pluck('propietario', 'docu_perso')->all()
        ];

        return view('manager.moviles.edit.vista', compact('data'));
    }

    public function update(Request $request, $nume_movil)
    {
        if($request->ajax()){
            Movil::find($nume_movil)->update($request->all());

            $mensaje = '<b>Nota: </b>Movil Modificado Correctamente.';
            return response()->json([
                'msg' => $mensaje, 
                'clr' => 'alert-success'
            ]);
        }
    }

    public function destroy(Request $request, $nume_movil)
    {
        if($request->ajax()){
            Movil::find($nume_movil)->delete();

            $mensaje = '<b>Nota: </b>Movil Eliminado Correctamente.';
            return response()->json([
                'msg' => $mensaje, 
                'clr' => 'alert-success'
            ]);
        }
    }
	public function listarMoviles(Request $request)
    {
        if($request->ajax())
        {
            try
            {
                $lst = ViewListarMoviles::where('docu_empre', $this->_docu_empre)->get();
				
                if($lst->count() > 0){
                    return response()->json([
                            'listado'   => $lst->toArray(),
                            'total'     => $lst->count()
                    ], 200);
                } else {
                    return response('Nota: No se Encontraron Servicios para el "Movil" Seleccionado.', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

	public function filtrarMovil(Request $request)
    {
        if($request->ajax())
        {
            try
            {
                $pate_movil = $request->pate_movil;
                $lst = ViewListarMoviles::where('pate_movil', 'LIKE', "%$pate_movil%")
                            ->where('docu_empre', $this->_docu_empre)
                            ->get();

                $mensaje = '<b>Nota: </b>Conductor Encontrado Correctamente.';          
                return response()->json([
                    'msg'     => $mensaje, 
                    'listado' => $lst->toArray(),
                    'total'   => $lst->count()
                ], 200);
            } catch (\Exception $e){
                    return response('Algo salio mal...!!!', 500);
            }
        }
    }
}
