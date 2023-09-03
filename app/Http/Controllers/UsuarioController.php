<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Http\Responses\TypeResponse;
use App\Servicio\UsuarioServicio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Matcher\Type;

class UsuarioController extends Controller
{
    //VISTA DEL USUARIO.
    public function showUsuarioForm(){

        $mensajes_usuario = session('data');
        return view('usuario', compact('mensajes_usuario'));
    }

    //CONTROLADOR DEL USUARIO.
    public function usuario_controller(Request $request){
        $cedula = $request->input('cedula');
        $nombres = $request->input('nombres');
        $usuario = $request->input('usuario');
        $clave = $request->input('clave');
        $id_rol = $request->input('id_rol');
        $id_titulo_academico = $request->input('id_titulo_academico');

        //VALIDACION DEL FORMULARIO DEL USUARIO
        $request->validate([
            'cedula' => 'required|numeric',
            'nombres' => 'required|string',
            'usuario' => 'required|string',
            'clave' => 'required|string',
            'id_rol' => 'required|integer',
            'id_titulo_academico' => 'required|integer'
        ]);


        $obj_tipo_respuesta = new TypeResponse();

        $data = new Collection([
            'tipo_consulta'=>3,
            'data'=>$cedula
        ]);
        
        $usuarioservicio = new UsuarioServicio();
        $respuesta = $usuarioservicio->createuser($data);

        if ($respuesta["data"]->cedula == $cedula && $respuesta["data"]->nombres == $nombres && $respuesta["data"]->usuario == $usuario && $respuesta["data"]->clave == $clave && $respuesta["data"]->id_rol == $id_rol && $respuesta["data"]->id_titulo_academico == $id_titulo_academico){
            return redirect(route('usuario'));
        }else {
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setmensagge('Credenciales invalidas');
        }
        return redirect(route('usuario'))->with('data',$obj_tipo_respuesta->getdata());

    }

    //EDITAR USUARIO
    public function editUser(Request $request, $id){
            
        //VALIDACION DEL USUARIO
        $request->validate([
            'cedula' => 'required|numeric',
            'nombres' => 'required|string',
            'usuario' => 'required|string',
            'clave' => 'required|string',
            'id_rol' => 'required|integer',
            'id_titulo_academico' => 'required|integer'
        ]);

        $obj_tipo_respuesta = new TypeResponse();

        $data = new Collection([
            'tipo_consultas' => 1,
            'data' => $id
        ]);

        $usuarioservicio = new UsuarioServicio();
        $respuesta = $usuarioservicio->editUser($data);

        if ($respuesta['data']->id_usuario == $id){
            return redirect(route('usuario'));
        }else {
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setok('Error al editar el usuario');
        }
        return redirect(route('usuario'))->with('data', $obj_tipo_respuesta->getdata());
    }

    //ElIMINAR USUARIO
    public function deleteUser($id){

        $obj_tipo_respuesta = new TypeResponse();
        
        $usuarioservicio = new UsuarioServicio();
        $respuesta = $usuarioservicio->deleteUser($id);

        if ($respuesta['ok']) {
            return redirect(route('usuario'));
        }else {
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setok('Error al eliminar el usuario');
        }
        return redirect(route('usuario'))->with('data', $obj_tipo_respuesta->getdata());
    }
}
