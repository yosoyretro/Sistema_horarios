<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Models\InstitutoModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use App\Servicio\InstitutoServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstitutoController extends Controller
{
    
    //VISTA DEL INSTITUTO
    public function ShowInstitutoForm(){
        $mensajes_instituto = session('data');
        return view('instituto', compact('mensajes_instituto'));
    }
    
    //CONTROLADOR DEL INSTITUTO
    public function instituto_controller(Request $request){
        $nombre = $request->input('nombre');
        $codigo = $request->input('codigo');
        //VALIDACION DEL INSTITUTO
        $request->validate([
            'nombre' => 'required|string',
            'codigo' => 'required|string'
        ]);

        $obj_tipo_respuesta = new TypeResponse();

        $data = new Collection([
            'tipo_consulta' => 3,
            'data' => $nombre
        ]);

        $institutoServicio = new InstitutoServicio();
        $respuesta = $institutoServicio->CreateInstituto($data);

        if ($respuesta['data']->nombre == $nombre && $respuesta['data']->codigo == $codigo){

            $instituto = new InstitutoModel();
            $instituto->nombre = $nombre;
            $instituto->codigo = $codigo;
            $instituto->save();
            
            return redirect(route('instituto'));
        } else {
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setok('Datos del Instituto Inválidos');
        }

        return redirect(route('instituto'))->with('data', $obj_tipo_respuesta->getdata());
    }
    public function createInstituto(Request $request){
        
        try{
            $codigo = $request->input("codigo");
            $nombre = $request->input("nombre");
        }catch(Exception $e){
            
        }
    }

    public function updateInstituto(Request $request){
        
    }
    public function deleteInstituto(Request $request){
        
    }

    

}