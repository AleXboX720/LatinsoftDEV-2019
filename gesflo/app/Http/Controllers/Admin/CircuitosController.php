<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Circuito;
use App\Modelos\Ruta;

use App\Modelos\Vistas\ViewListarCircuitos;
use App\Modelos\Vistas\ViewListarPuntosControl;

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

    public function editar(Request $request)
    {

        //$req = $this->detallarCircuito($request);
        dd($request);
    }
    public function detallarCircuito(Request $request)
    {
        if($request->ajax())
        {
            $codi_circu = $request->codi_circu;
            try
            {
                $c = Circuito::where('codi_circu', $codi_circu)
                            ->where('docu_empre', $this->_docu_empre)
                            ->get();
                
                $r  = Ruta::where('codi_circu', $codi_circu)
                            ->where('docu_empre', $this->_docu_empre)
                            ->get();
                $l = [];
                foreach ($r as $ruta) {
                    $codi_senti = $ruta['codi_senti'];

                    $control = ViewListarPuntosControl::where('codi_circu', $codi_circu)
                            ->where('docu_empre', $this->_docu_empre)
                            ->where('codi_senti', $codi_senti)
                            ->get();
                    array_push($l, ['sentido' => $codi_senti, 'controles' => $control->toArray()]);

                }
                /*
                $l = ViewListarPuntosControl::where('codi_circu', $codi_circu)
                            ->where('docu_empre', $this->_docu_empre)
                            ->get();
                */
                return response()->json([
                    'circuito'  => $c,
                    'rutas'     => $r,
                    'listado' => $l
                ]);
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
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