<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Services\UsuarioServicio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AutenticacionController extends Controller
{
    //
    protected $servicio_usuario;
    
    public function __construct()
    {
        $this->servicio_usuario = new UsuarioServicio();
    }
    public function autenticacion(Request $request)
    {
        try{
            $servicio_usuario = $this->servicio_usuario->getdatausuario([
                "tipo_consulta"=>3,
                "usuario"=>$request->input("usuario")
            ]);
            if(!$servicio_usuario["ok"])throw new Exception($servicio_usuario["msg_error"]);
            if(!collect($servicio_usuario["data"])->first())throw new Exception("El usuario no existe");
            if(!password_verify($request->clave,collect($servicio_usuario["data"])->first()["clave"]))throw new Exception("La contraseña esta incorrecta");
            $token = $this->servicio_usuario->createTokenById(collect($servicio_usuario["data"])->first()["id_usuario"]);
            if(!$token["ok"])throw new Exception($token["msg_error"]);
            return Response()->json([
                "ok"=>true,
                "data"=>$servicio_usuario["data"],
                "token" => $token["data"],
                "mensaje" => "El tiempo del token expira en 1hora"
            ],200);
        }catch(Exception $e){
            return Response()->json([
                "ok"=>false,
                "mensaje" => $e->getMessage(),
                "Linea"=>$e->getLine()
            ],500);
        }
    }  
}
