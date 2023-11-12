<?php

namespace App\Http\Controllers;

use App\Models\UsuarioModel;
use App\Http\Responses\TypeResponse;
use App\service\UsuarioServicio as ServiceUsuarioServicio;
use App\Services\UsuarioServicio;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Matcher\Type;

class UsuarioController extends Controller
{
    private $servicio_usuario,$servicio_validaciones;
    //VISTA DEL USUARIO
    public function __construct()
    {
        $this->servicio_usuario = new UsuarioServicio();

    }

    public function createUsuario(Request $request)
    {
        try{
            $servicio_usuario = $this->servicio_usuario->createuser($request->all());
            log::alert(collect($servicio_usuario));
        }catch(Exception $e){
            
        }
        return json_encode($servicio_usuario);
    }
}
