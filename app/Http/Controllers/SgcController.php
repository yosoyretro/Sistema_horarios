<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Servicio\RolServicio;
use App\Servicio\UsuarioServicio;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SgcController extends Controller
{
    //VISTA DEL LOGIN 
    public function login(){
        
        $mensajes_temporales = session('data');
        return view('login',compact('mensajes_temporales'));
    }
    
    //CONTROLADOR DEL LOGIN 
    public function login_controlador(Request $request){
        $user = $request->input('user');
        $password = $request->input('password');
        
        $obj_tipo_respuesta = new TypeResponse();

        $data = new Collection([
            'tipo_consulta'=>3,
            'data'=>$user
        ]);
        
        $servicio = new UsuarioServicio();
        $respuesta = $servicio->getdatausuario($data);
        if($respuesta["data"]){
            if($respuesta["data"][0]->usuario == $user && $respuesta["data"][0]->clave == $password){
                return redirect(route('inicio'));
            }else{
                $obj_tipo_respuesta->setok('false');
                $obj_tipo_respuesta->setmensagge('credenciales invalidas');
            }
        }else{
            $obj_tipo_respuesta->setok('false');
            $obj_tipo_respuesta->setmensagge('Este usuario no se encuentra registrado en la base de datos');
        }

        return redirect(route('login'))->with('data',$obj_tipo_respuesta->getdata());

    }
    

    public function inicio(){
        
        return view('inicio');

    }
    public function usuario(){
        $servicioUsuario = new UsuarioServicio();
        $servicioRol = new RolServicio();

        $data = new Collection([
            'tipo_consulta'=>4
        ]);

        $rol_datos = $servicioRol->Consultar()["data"];
        
        $usuarios_datos = [$servicioUsuario->getdatausuario($data)["data"]];
        log::alert($rol_datos);
        return view('Usuario',compact('usuarios_datos','rol_datos'));
    }

    public function eliminarRegistro(Request $request,$id,$op){
        $response = new TypeResponse();
        switch($op){
            case 1:
                $servicioUsuario = $servicioUsuario = new UsuarioServicio();
                $servicioUsuario->deleteUser($id);
                $response->setdata("Usuario Eliminado con exito");
            case 2:
                //Instituto
            case 3:
                //carrera
            case 4:
                //rol
            case 5:
                //        

        }
        return Response()->json($response->getdata());
    }
}
