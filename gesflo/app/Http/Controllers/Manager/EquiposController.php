<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modelos\Vistas\ViewListarDevices;
use App\Modelos\Vistas\ViewListarMoviles;
use App\Modelos\Equipo;

class EquiposController extends Controller
{

    public function index(Request $request)
    {
        $data = 
        [
            'title'     => 'Manager',
            'subtitle'  => 'Equipo (Device)',
            'buscare'   => 'nume_imei',
        ];

        return view('manager.equipos.vista', compact('data'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($codi_equip)
    {
    }

    public function edit($deviceID)
    {
        $data = 
        [
            'title'     => 'Editar',
            'subtitle'  => 'Equipo (Device)',
            'buscare'   => 'nume_imei',
            'equipo'    => ViewListarDevices::where('deviceID', $deviceID)->where('accountID', $this->_accountID)->where('groupID', $this->_groupID)->limit(1)->get(),
            'movil'     => ViewListarMoviles::where('codi_equip', $deviceID)->where('docu_empre', $this->_docu_empre)->limit(1)->get()
        ];
        
        return view('administrador.equipos.edit.vista',  compact('data'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function listarEquipos(Request $request)
    {
        if($request->ajax()){
            try{
                    $lst = ViewListarDevices::where('accountID', $this->_accountID)
                        ->where('groupID', $this->_groupID)
                        ->orderBy('deviceID', 'ASC')
                        ->get();
                            
                    return response()->json([
                            'listado' => $lst->toArray(),
                            'total' => $lst->count()
                    ], 200);
                } catch (\Exception $e){
                    return response('Algo salio mal...!!!', 500);
            }
        }
    }


    public function buscarEquipo(Request $request)
    {
        $nume_imei = $request->nume_imei;
        $listado = ViewListarDevices::where('imeiNumber', 'LIKE', "%$nume_imei%")
                    ->where('accountID', $this->_accountID)
                    ->where('groupID', $this->_groupID)
                    ->get();

        $mensaje = '<b>Nota: </b>Dispositivo Encontrado Correctamente.';          
        return response()->json([
            'msg'        => $mensaje, 
            'listado'    => $listado
        ], 200);
    }
}
