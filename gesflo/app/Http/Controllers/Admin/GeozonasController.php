<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarGeozonas;

class GeozonasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Administracion',
            'subtitle'  => 'Geozonas de Control',
            'buscare'   => 'nomb_geozo'
        ];

        return view('administrador.geozonas.vista', compact('data'));
    }

    public function listarGeozonas(Request $request)
    {
        if($request->ajax()){
            try{
                $lst = ViewListarGeozonas::get();
                return response()->json([
                        'listado' => $lst->all(),
                        'total' => $lst->count()
                ], 200);
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    public function show(Request $request, $geozonaID)
    {
        if($request->ajax()){
            $objeto = ViewListarGeozonas::find($geozonaID);
            return $objeto;
        }
    }

    public function edit($geozonaID)
    {
        dd(ViewListarGeozonas::find($geozonaID)->toArray());
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'GeoZona',
            'listado'   => ViewListarGeozonas::find($geozonaID)
        ];

        //return view('administrador.geozonas.edit.vista', compact('data'));
    }

    public function filtrarGeozonas(Request $request)
    {
        $nomb_geozo = $request->nomb_geozo;
        try{
            $lst = ViewListarGeozonas::
                        where('description', 'LIKE', "%$nomb_geozo%")
                        ->get();
            //dd($lst->toArray());
            if($lst->count() > 0){
                return response()->json([
                        'listado'   => $lst->toArray(),
                        'total'     => $lst->count()
                ], 200);
            } else {
                return response('Nota: No se Encontraron GeoZonas Definidas.', 404);
            }
            
        } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
        }
    }
}
