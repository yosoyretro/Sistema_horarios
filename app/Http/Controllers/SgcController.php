<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Services\UsuarioServicio as ServicesUsuarioServicio;
use App\Services\RolServicio;
use App\Services\TituloAcademicoServicio;
use App\Servicio\UsuarioServicio;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

class SgcController extends Controller
{
    //VISTA DEL LOGIN 
    public function login()
    {
        $mensajes_temporales = session('data');
        return view('login', compact('mensajes_temporales'));
    }

    //CONTROLADOR DEL LOGIN 
    public function login_controlador(Request $request)
    {
        $user = $request->input('user');
        $password = $request->input('password');

        $obj_tipo_respuesta = new TypeResponse();

        $data = new Collection([
            'tipo_consulta' => 3,
            'data' => $user
        ]);

        // $servicio = new UsuarioServicio();
        // $respuesta = $servicio->getdatausuario($data);

        // if($respuesta["data"]){
        //     if($respuesta["data"]->usuario == $user && $respuesta["data"]->clave == $password){
        //         return redirect(route('inicio'));
        //     }else{
        //         $obj_tipo_respuesta->setok('false');
        //         $obj_tipo_respuesta->setmensagge('credenciales invalidas');
        //     }
        // }else{
        //     $obj_tipo_respuesta->setok('false');
        //     $obj_tipo_respuesta->setmensagge('Este usuario no se encuentra registrado en la base de datos');
        // }

        return redirect(route('login'))->with('data', $obj_tipo_respuesta->getdata());
    }

    public function inicio()
    {

        return view('inicio');
    }

    public function asignaciones()
    {
        return view('asignaciones');
    }

    public function curso_y_materia()
    {
        return view('curso_y_materia');
    }
    public function carrera()
    {
        return view('carrera');
    }
    public function usuarios()
    {
        $servicio_titulo = new TituloAcademicoServicio();
        $servicio_rol = new RolServicio();
        $servicio = new ServicesUsuarioServicio();

        $data = $servicio->getdatausuario(['tipo_consulta' => 4]);
        $data_rol = $servicio_rol->Consultar(['tipo_consulta' => 3]);
        $data_titulo = $servicio_titulo->consultarTitulo(6);

        if (!$data["ok"]) {
            $datos = [];
        } else {
            $datos = $data["data"];
        }

        if (!$data_rol["ok"]) {
            $roles = [];
        } else {
            $roles = $data_rol["data"];
        }

        log::alert($data_titulo);
        if (!$data_titulo["ok"]) {
            $titulos_academico = [];
        } else {
            $titulos_academico = $data_titulo["data"];
            log::alert("SOY EL DE USUARIO");
            log::alert(collect($titulos_academico));
            log::alert($datos);
            if ($titulos_academico == null) {
                $titulos_academico = [];
            }
        }

        return view('usuarios')->with('titulos_academico', $titulos_academico)->with('roles', $roles)->with('data', $datos);
    }

    public function horarios()
    {
        return view('horarios');
    }
}
