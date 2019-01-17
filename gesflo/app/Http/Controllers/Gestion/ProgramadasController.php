<?php

namespace App\Http\Controllers\Gestion;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Programada;
use App\Modelos\Servicio;
use App\Modelos\Multa;

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
        //dd($request);
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

            $programada = $this->_buscarProgramada($codi_servi, $codi_circu, $codi_senti, $g);

            if($programada->count() > 0)
            {
                $fech_progr = $programada[0]['fech_progr'];
                $minu_toler = $programada[0]['minu_toler'];
                $procesado = $programada[0]['procesado'];
                //if(!$procesado){
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
                
                //usleep(70000);
                //}
                unset($programada);
            }
        }
        unset($arribos);

        $multado = false;
        if($totalMulta > 0)
        {
            $multado = true;
            Multa::create([
                'codi_servi' => $codi_servi,
                'codi_circu' => $codi_circu,
                'nume_movil' => $nume_movil,
                'codi_senti' => $codi_senti,
                'tota_multa' => $totalMulta,
                'fech_multa' => date('Y-m-d', $codi_servi),
                'user_modif' => \Auth::user()->docu_perso,
            ]);
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

    private function _calcularMulta($diferencia, $tolerancia)
    {
        $multa = 0;
        if($tolerancia === 99){
            return $multa;
        } elseif($tolerancia > 0){
            if($diferencia > $tolerancia){
                return ($diferencia - $tolerancia) * $this->_valor_multa;
            }
            return $multa;
        }
        if($diferencia > 0){
            return $diferencia * $this->_valor_multa;
        }
        return $multa;
    }

    private function _buscarProgramada($s, $c, $e, $g)
    {
        try
        {
            return Programada::
                where('codi_servi', $s)
                ->where('codi_circu', $c)
                ->where('codi_senti', $e)
                ->where('codi_geoce', $g)
                ->where('procesado', 0)
                ->get();
        } catch (\Exception $e){
            return response('No se Encontro Programada, para ser Actualizada...!!!', 500);
        }
    }

    private function _actualizarProgramada($s, $c, $e, $g, $f, $lat, $lon, $h, $v, $d, $t, $m)
    {
        \DB::beginTransaction();
        try
        {
            Programada::
            where('codi_servi', $s)
            ->where('codi_circu', $c)
            ->where('codi_senti', $e)
            ->where('codi_geoce', $g)
            ->where('procesado', 0)			
            ->update(
            [
                'fech_contr' => date('Y-m-d H:i:s', $f),
                'latitud'    => $lat,
                'longitud'   => $lon,
                'grad_angul' => $h,
                'velo_contr' => intval($v),
                'dife_contro'=> intval($d),
                'tota_multa' => $t,
                'procesado'  => true,
                'multado'    => $m
            ]);
        } catch (\Exception $e){
            \DB::rollback();
            return response('Algo salio mal...!!!', 500);
        }
        \DB::commit();
    }
}