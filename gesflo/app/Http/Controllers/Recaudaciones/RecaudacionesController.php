<?php

namespace App\Http\Controllers\Recaudaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewMultasRecaudadas;
use App\Modelos\Vistas\ViewUsuarios;

use App\Modelos\Multa;


class RecaudacionesController extends Controller
{

    public function index()
    {
        $data = [
            'title'     => 'Recaudaciones',
            'subtitle'  => 'Estadisticas',
            'lstUsuarios'   => ViewUsuarios::_listar($this->_docu_empre)
        ];
        return view('recaudaciones.vista', compact('data'));
    }

    public function MultasDiarias(Request $request)
    {
        //if($request->ajax()){
            try
            {
                $user_modif = $request->user_modif;
                $fech_desde = strtotime('+0 day' , strtotime($request->fech_desde));
                $fech_hasta = strtotime('+1 day' , strtotime($request->fech_hasta));

                $multas = ViewMultasRecaudadas::_listar($user_modif, $fech_desde, $fech_hasta);
                $total = $multas->count();
                if($total > 0)
                {
                    $moviles = [];
                    $multados = [];
                    $cobrados = [];
                    foreach ($multas as $obj) {
                        array_push($moviles, $obj['nume_movil']);
                        array_push($multados, intval($obj['multado']));
                        array_push($cobrados, intval($obj['cobrado']));
                    }
                    unset($multas);

                    $mensaje = 'Hay: ' .$total. ' Moviles con Multas encontradas.';                    
                    return response()->json([
                            'moviles'   => $moviles,
                            'multados'   => $multados,
                            'cobrados'   => $cobrados,
                            //'total'     => $total,
                            'msg'       => $mensaje
                    ], 200);
                } else {
                    return response('No se Encontraron Multas para Este Dia!!!', 404);
                }
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        //}
    }
	
}