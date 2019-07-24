<?php
namespace App\Http\Controllers\Recaudaciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\DBServicios\ViewMultasRecaudadas;
//use App\Modelos\Vistas\ViewMultasRecaudadas;
use App\Modelos\Vistas\ViewUsuarios;

use App\Modelos\Multa;
use App\Modelos\Pago;

use Carbon\Carbon;
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
                $u = $request->user_modif;
				$d = Carbon::parse($request->fech_desde)->toDateTimeString();
				$h = Carbon::parse($request->fech_hasta)->addDays(1)->toDateTimeString();				
				
                $multas = ViewMultasRecaudadas::_listar($u, $d, $h);

                $total = $multas->count();
                if($total > 0)
                {
                    $moviles = [];
                    $multados = [];
                    $cobrados = [];

                    $totales = [];
                    $total_multas = 0;
                    $total_cobros = 0;
                    foreach ($multas as $obj) {
                        $valo_multa = intval($obj['multado']);
                        $valo_cobra = intval($obj['cobrado']);
                        $total_multas = $total_multas + $valo_multa;
                        $total_cobros = $total_cobros + $valo_cobra;
                        array_push($moviles, $obj['nume_movil']);
                        array_push($multados, $valo_multa);
                        array_push($cobrados, $valo_cobra);
                    }
                    $totales['total_multas'] = $total_multas;
                    $totales['total_cobros'] = $total_cobros;
                    unset($multas);

                    //$mensaje = 'Hay: ' .$total. ' Moviles con Multas encontradas.';
                    return response()->json([
                            'moviles'   => $moviles,
                            'multados'  => $multados,
                            'cobrados'  => $cobrados,
                            'totales'   => $totales,
                            //'fechas'    => $fechas,
                            //'total'     => $total,
                            //'msg'       => $mensaje
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