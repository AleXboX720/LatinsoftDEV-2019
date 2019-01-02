<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarCircuitos;

class CircuitosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {        
        $data = [
            'title'     => 'Administracion',
            'subtitle'  => 'Circuitos',
            'buscare'   => 'nomb_circu'
        ];
        return view('administrador.circuitos.vista', compact('data'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function listarCircuitos(Request $request)
    {
        if($request->ajax()){
            try{
                $lst = ViewListarCircuitos::orderBy('codi_circu', 'ASC')->get();
                return response()->json([
                        'listado' => $lst->all(),
                        'total' => $lst->count()
                ], 200);
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function filtrarCircuitos(Request $request)
    {
        $nomb_circu = $request->nomb_circu;
        try{
            $lst = ViewListarCircuitos::
                        where('nomb_circu', 'LIKE', "%$nomb_circu%")
                        ->get();
            //dd($lst->toArray());
            if($lst->count() > 0){
                return response()->json([
                        'listado'   => $lst->toArray(),
                        'total'     => $lst->count()
                ], 200);
            } else {
                return response('Nota: No se Encontraron RUTAS con ese Nombre...!!!', 404);
            }
            
        } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
        }
    }
}