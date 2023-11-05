<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Servicio\UsuarioServicio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SgcController extends Controller
{
    //VISTA DEL LOGIN 
    // public function login(){    
    //     $mensajes_temporales = session('data');
    //     return view('login',compact('mensajes_temporales'));
    // }
    
    // //CONTROLADOR DEL LOGIN 
    // public function login_controlador(Request $request){
    //     $user = $request->input('user');
    //     $password = $request->input('password');
        
    //     $obj_tipo_respuesta = new TypeResponse();

    //     $data = new Collection([
    //         'tipo_consulta'=>3,
    //         'data'=>$user
    //     ]);
        
    //     $servicio = new UsuarioServicio();
    //     $respuesta = $servicio->getdatausuario($data);

    //     if($respuesta["data"]){
    //         if($respuesta["data"]->usuario == $user && $respuesta["data"]->clave == $password){
    //             return redirect(route('inicio'));
    //         }else{
    //             $obj_tipo_respuesta->setok('false');
    //             $obj_tipo_respuesta->setmensagge('credenciales invalidas');
    //         }
    //     }else{
    //         $obj_tipo_respuesta->setok('false');
    //         $obj_tipo_respuesta->setmensagge('Este usuario no se encuentra registrado en la base de datos');
    //     }

    //     return redirect(route('login'))->with('data',$obj_tipo_respuesta->getdata());

    // }
    
}
