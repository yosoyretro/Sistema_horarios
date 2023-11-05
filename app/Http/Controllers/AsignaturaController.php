<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Responses\TypeResponse;
use App\Services\AsignaturaServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{

    private $servicio_asignatura, $validaciones;
    public function __construct()
    {
        $this->servicio_asignatura = new AsignaturaServicio();
        $this->validaciones = new Validaciones();
    }

    public function CreateAsignatura(Request $request)
    {
        $response = new TypeResponse();

        try {


            $validaciones = $this->validaciones->validarRegistroForAsignatura(2, [
                "codigo" => $request->input('codigo'),
                "nombre" => $request->input('descripcion'),
                "tipo_validacion_existencia" => false
            ]);

            if (!$validaciones["ok"]) throw new Exception($validaciones["msg_error"]);
            $servicioAsignatura = $this->servicio_asignatura->createAsignatura(
                [
                    "codigo" => $request->input('codigo'),
                    "descripcion" => $request->input('descripcion'),
                ]
            );

            if (!$servicioAsignatura["ok"]) throw new Exception($servicioAsignatura["msg_error"]);
            $response->setmensagge($servicioAsignatura["msg"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }

    public function updateAsignatura(Request $request)
    {
        $response = new TypeResponse();
        try {
            
            $validacion = $this->validaciones->validarRegistroForAsignatura(1, 
            [
                "id_asignatura" => $request->input('id_asignatura'),
                "codigo" => $request->input('codigo'),
                "descripcion" => $request->input('descripcion'),
                "tipo_validacion_existencia" => false
            ]);

            if (!$validacion["ok"]) throw new Exception($validacion["msg_error"]);
            
            $servicio_asignatura = $this->servicio_asignatura->updateAsignatura([
                "id_asignatura" => $request->input("id_asignatura"),
                "codigo" => $request->input("codigo"),
                "descripcion" => $request->input("descripcion"),
            ]);
            if(!$servicio_asignatura["ok"])throw new Exception($servicio_asignatura["msg_error"]);
            
            $response->setmensagge($servicio_asignatura["msg"]);
            $response->setdata($servicio_asignatura["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    public function deleteAsignatura(Request $request)
    {
        $response = new TypeResponse();
        try {
            $validacion = $this->validaciones->validarRegistroForAsignatura(1, ["id_asignatura" => $request->input('id_asignatura')]);
            if (!$validacion["ok"]) throw new Exception($validacion["msg_error"]);
            $servicio_asignatura = $this->servicio_asignatura->deleteAsignatura($request->input("id_asignatura"));
            $response->setdata($servicio_asignatura["data"]);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());
    }

    public function showAsignatura(Request $request)
    {
        $response = new TypeResponse();
        try{
            $data = $this->servicio_asignatura->Consultar(["tipo_consulta"=>7]);
            if(!$data["ok"])throw new Exception($data["msg_error"]);
            $response->setdata($data["data"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getCode());
        }
        return json_encode($response->getdata());
        
    }
}
