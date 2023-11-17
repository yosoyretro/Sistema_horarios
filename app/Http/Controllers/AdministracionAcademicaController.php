<?php

namespace App\Http\Controllers;

use App\Http\Responses\TypeResponse;
use App\Models\AdministracionAcademicaModel;
use App\Services\AdministracionAcademicaServicio;
use App\Services\Validaciones;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdministracionAcademicaController extends Controller
{
    
    //VISTA DE ADMINISTRACION ACADEMICA
    private $validaciones_clase,$obj_service_AdministracionAcademica;

    public function __construct()
    {
        $this->validaciones_clase = new Validaciones();
        $this->obj_service_AdministracionAcademica = new AdministracionAcademicaServicio();
    }

    public function showAdministracion()
    {

        try{
            $response = new TypeResponse();
            $obj_service_AdministracionAcademica = $this->obj_service_AdministracionAcademica->ConsultarAdministracion(6);
            $response->setdata($obj_service_AdministracionAcademica["data"]);
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }

    
    //CREAR ADMINISTRACION ACADEMICA
    public function CreateAdministracion(Request $request) 
    {
        try {
            $response = new TypeResponse();
            $datos = [
                'id_carrera' => $request->input('id_carrera'),
                'id_instituto' => $request->input('id_instituto')
            ];
            
            $validacion_administracion = $this->validaciones_clase->validarRegistroForAdministracionAcademica(2, array_merge($datos,["tipo_validacion_existencia" => true]));
            if(!$validacion_administracion["ok"]) throw new Exception($validacion_administracion["msg_error"]);

            $request_servicio = $this->obj_service_AdministracionAcademica->CreateAdministracion($datos);
            if(!$request_servicio["ok"]) throw new Exception($request_servicio["msg_error"]);

            $response->setmensagge("Administracion Academica Creado con exito !");

        } catch(Exception $e){
            log::alert("Funcion de Administracion Academica");
            log::alert("Linea del error :" . $e->getLine());

            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());

        }

        return json_decode($response->getdata());
    }

    


    public function UpdateAdministracion(Request $request) 
    {
        try{
            $response = new TypeResponse();

            $validacion_administracion = $this->validaciones_clase->validarRegistroForAdministracionAcademica(1, $request->all());
            if (!$validacion_administracion["ok"]) throw new Exception($validacion_administracion["msg_error"]);
            if (!$validacion_administracion["ok"] && !$validacion_administracion["data"]) throw new Exception($validacion_administracion["exception"]);

            $obj_service_AdministracionAcademica = $this->obj_service_AdministracionAcademica->UpdateAdministracion($request->all());
            if (!$obj_service_AdministracionAcademica["ok"]) throw new Exception($obj_service_AdministracionAcademica["msg_error"]);

            $response->setmensagge("Administracion Academica actualizada con éxito");
        }catch(Exception $e){
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
        }
        return json_encode($response->getdata());
    }


    public function DeleteAdministracion(Request $request)
    {
        try {
            $response = new TypeResponse();

            $validacion_administracion = $this->validaciones_clase->validarRegistroForAdministracionAcademica(1, ["id_administracion_academica" => $request->input('id_administracion_academica')]);
            if (!$validacion_administracion["ok"]) throw new Exception($validacion_administracion["msg_error"]);
            if (!$validacion_administracion["ok"] && !$validacion_administracion["data"]) throw new Exception($validacion_administracion["exception"]);

            $obj_service_AdministracionAcademica = $this->obj_service_AdministracionAcademica->DeleteAdministracion($request->input('id_administracion_academica'));
            if (!$obj_service_AdministracionAcademica["ok"]) throw new Exception($obj_service_AdministracionAcademica["msg_error"]);

            $response->setmensagge("Adminstracion Academica eliminada con éxito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge("A ocurrido un error en eliminar la Administracion Academica");
            $response->seterror($e->getMessage(), $e->getLine());
        }
        return json_encode($response->getdata());

    }
            

}
