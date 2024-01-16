<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Responses\TypeResponse;
use App\Services\AsignaturaServicio;
use Exception;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{

    private $servicio_asignatura;
    public function __construct()
    {
        $this->servicio_asignatura = new AsignaturaServicio();
        
    }

    public function CreateAsignatura(Request $request)
    {
        $response = new TypeResponse();

        try {
            $servicioAsignatura = $this->servicio_asignatura->createAsignatura(
                [
                    "codigo" => $request->input('codigo'),
                    "descripcion" => $request->input('descripcion')
                ]
            );
            if (!$servicioAsignatura["ok"]) throw new Exception($servicioAsignatura["msg_error"]);
            $response->setmensagge($servicioAsignatura["msg"]);
        } catch (Exception $e) {
            log::alert("A ocurrido un error en el controlador de create Asignatura");
            log::alert("Linea : " . $e->getLine());
            log::alert("Mensaje : " . $e->getMessage());
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
        }

        return json_encode($response->getdata());
    }

    public function updateAsignatura(Request $request)
    {
        $response = new TypeResponse();
        try {
            
            $servicio_asignatura = $this->servicio_asignatura->updateAsignatura([
                "id_asignatura" => $request->input("id_asignatura"),
                "codigo" => $request->input("codigo"),
                "descripcion" => $request->input("descripcion"),
            ]);
            if(!$servicio_asignatura["ok"])throw new Exception($servicio_asignatura["msg_error"]);
            $response->setmensagge($servicio_asignatura["msg"]);
        } catch (Exception $e) {
            log::alert("A ocurrido un error en la funcion de updateAsignatura");
            log::alert("Mensaje : " . $e->getMessage());
            log::alert("Linea : " . $e->getLine());
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }

    public function deleteAsignatura(Request $request)
    {
        $response = new TypeResponse();
        try {
            log::alert("SOy el request de eliminar ");
            log::alert(collect($request));
            $servicio_asignatura = $this->servicio_asignatura->deleteAsignatura($request->input("id_asignatura"));
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
