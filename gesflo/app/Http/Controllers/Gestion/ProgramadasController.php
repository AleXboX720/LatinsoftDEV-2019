<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Modelos\DBServicios\ViewListarProgramadas;
use App\Modelos\DBServicios\Programada;
use App\Modelos\Servicio;
use App\Modelos\Multa;

//-----------------------------------
use Carbon\Carbon;
class ProgramadasController extends Controller
{
    private $_valor_multa = 1000;

    public function update(Request $request)
    {
        if($request->ajax()){
            try{
    			$this->_procesar($request);                //TODO
                
                $mensaje = 'Programadas del Servicio Procesadas Correctamente.';
                return response()->json([
                    'msg'   => $mensaje, 
                    'status'=> 'ok',
                    'clr'   => 'alert-success'
                ], 200);
            } catch (\Exception $e){
                return response('Algo salio mal...!!!', 500);
            }
        }
    }

    private function _procesar(Request $request)
    {
        $marcadas   = $request['marcadas'];
        $codi_servi = $request['codi_servi'];
        $codi_circu = $request['codi_circu'];
        $codi_senti = $request['codi_senti'];

        $nume_movil = $request['nume_movil'];
        $pate_movil = $request['pate_movil'];

        $totalMulta = 0;
        $servicio_multado = false;

        foreach($marcadas as $arribo){
            $g = $arribo['geozoneID'];

            $programadas = ViewProgramadas::_listar($codi_servi, $codi_circu, $codi_senti, $g);

            foreach($programadas as $programada){
                $cabecera   = intval($arribo['heading']);
                $angulo     = $programada['angulo'];

                $valido = $this->_anguloIncidente($cabecera, $angulo);
                if($valido)
                {
                    $fech_progr = $programada['fech_progr'];
                    $minu_toler = $programada['minu_toler'];
                    //$procesado  = $programada['procesado'];
                    $f = $arribo['timestamp'];
                    $lat = $arribo['latitude'];
                    $lon = $arribo['longitude'];
                    $h = $arribo['heading'];
                    $v = $arribo['speedKPH'];

                    $d = floor(($f - strtotime($fech_progr)) / 60);
                    $multa = $this->_calcularMulta($d, $minu_toler);
                    $totalMulta += $multa;
                    
                    $multado = false;
                    if($multa > 0){
                        $multado = true;
                    }

                    $this->_actualizarProgramada($codi_servi, $codi_circu, $codi_senti, $g, $f, $lat, $lon, $h, $v, $d, $multa, $multado);
                    
                    usleep(30000);
                }
            }
        }
        unset($arribos);

        $multado = false;
        if($totalMulta > 0)
        {
            $multado = true;
            Multa::_crear($codi_servi, $codi_circu, $nume_movil, $codi_senti, $totalMulta, date('Y-m-d', $codi_servi));
        }
        Servicio::where('codi_servi', $codi_servi)
            ->where('codi_circu', $codi_circu)
            ->where('nume_movil', $nume_movil)
            ->where('pate_movil', $pate_movil)
            ->where('multado', false)
            ->update(
            [
                'multado'   => $multado,
                'procesar'  => false
            ]);
    }

    public function procesarProgramadas($servicio, $controladas, $codi_senti)
    {
        $codi_servi = $servicio['codi_servi'];
        $codi_circu = $servicio['codi_circu'];
        $nume_movil = $servicio['nume_movil'];
        $pate_movil = $servicio['pate_movil'];

        $totalMulta = 0;
        $servicio_multado = false;

        foreach($controladas as $controlada){
            $codi_geoce = $controlada['geozoneID'];
            $programada = $this->_buscarProgramada($servicio, $codi_geoce, $codi_senti);
            
            if($programada->count() > 0){
                $cabecera   = intval($controlada['heading']);
                $angulo     = $programada[0]['angulo'];

                $valido = $this->_anguloIncidente($cabecera, $angulo);
                if($valido)
                {
                    $fech_progr = $programada[0]['fech_progr'];
                    $minu_toler = $programada[0]['minu_toler'];

                    $d = floor(($controlada['timestamp'] - strtotime($fech_progr)) / 60);
                    $multado = false;
                    $multa = 0;
                    if(intval($minu_toler) != 99)
                        if(intval($d) > 0){
                        {
                            $multado = true;
                            $multa = $this->_calcularMulta(intval($d), intval($minu_toler));

                        }
                    }
                    $totalMulta += $multa;
                    
                    $this->_actualizarProgramada($servicio, $controlada, $codi_senti, $d, $multa, $multado);
                    usleep(10000);
                }
            }
        }
        unset($controlada);

        $multado = false;
        if($totalMulta > 0)
        {
            $multado = true;
            Multa::_crear($codi_servi, $codi_circu, $nume_movil, $codi_senti, $totalMulta, date('Y-m-d', $codi_servi));
        }
        Servicio::where('codi_servi', $codi_servi)
            ->where('codi_circu', $codi_circu)
            ->where('nume_movil', $nume_movil)
            ->where('pate_movil', $pate_movil)
            ->where('multado', false)
            ->update(
            [
                'multado'   => $multado,
                'procesar'  => false
            ]);
    }

    public function _calcularMulta($diferencia, $tolerancia)
    {
        $multa = 0;
        if($tolerancia > 0){
            if($diferencia > $tolerancia){
                return ($diferencia - $tolerancia) * $this->_valor_multa;
            }
        }elseif($diferencia > 0){
            return $diferencia * $this->_valor_multa;
        }
        return $multa;
    }

    private function _buscarProgramada($servicio, $codi_geoce, $codi_senti)
    {
        $codi_servi = $servicio['codi_servi'];
        $codi_circu = $servicio['codi_circu'];

        return ViewListarProgramadas::_buscar($codi_servi, $codi_circu, $codi_senti, $codi_geoce);
    }

    private function _actualizarProgramada($servicio, $controlada, $codi_senti, $d, $multa, $multado)
    {
        $codi_servi = $servicio['codi_servi'];
        $codi_circu = $servicio['codi_circu'];

        $codi_geoce = $controlada['geozoneID'];
        $f = $controlada['timestamp'];
        $lat = $controlada['latitude'];
        $lon = $controlada['longitude'];
        $h = $controlada['heading'];
        $v = $controlada['speedKPH'];

        $programada = Programada::_actualizarProgramada($codi_servi, $codi_circu, $codi_senti, $codi_geoce, $f, $lat, $lon, $h, $v, $d, $multa, $multado);
    }

    private function _anguloIncidente($cabecera, $angulo)
    {
        $incidencia = false;

        if($angulo == 0){
            $min = 360 - 30;
            $max = 0 + 30;

            if(($cabecera >= $min && $cabecera <= 360)|| ($cabecera >= 0 && $cabecera <= $max))
            {
                $incidencia = true;
            }
        } else {
            $min = intval($angulo) - 30;
            $max = intval($angulo) + 30;

            if($cabecera >= $min && $cabecera <= $max)
            {
                $incidencia = true;
            }
        }
        return $incidencia;
    }
}