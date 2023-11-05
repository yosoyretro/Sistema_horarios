<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\InstitutoModel;
use Illuminate\Support\Facades\Log;

use Exception;

class InstitutoServicio
{
    protected $obj_instituto_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_instituto_modelo = new InstitutoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }

    public function CreateInstituto($datos_array)
    {
        try {
            log::alert($datos_array);
            $nuevoInstituto = InstitutoModel::create(
                [
                    "codigo"=>$datos_array["codigo"],
                    "nombre"=>$datos_array["nombre"],
                    "estado"=>"A",
                    "fecha_creacion" => now(),
                    "fecha_actualizacion" => now(),
                ]
            );
            
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($nuevoInstituto);
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror($e->getMessage(),false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function UpdateInstituto($institutoData)
    {
        $response = new TypeResponse();
        try {

            $instituto = InstitutoModel::where("id_instituto",$institutoData['id_instituto'])->update(
                [
                    "codigo"=>$institutoData['codigo'],
                    "nombre"=>$institutoData['nombre'],
                    "fecha_actualizacion" => now()
                ]
            );
            $response->setdata($instituto);
            $response->setmensagge("Instituto Actualizado con exito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror('Error al editar el instituto', false);
        }

        return $response->getdata();
    }

    public function DeleteInstituto($institutoData)
    {
        $response = new TypeResponse();

        try {

            $instituto = InstitutoModel::where("id_instituto",$institutoData)->update(
                [
                    "estado"=>"I",
                    "fecha_actualizacion" => now()
                ]
            );
            $response->setmensagge("Instituto eliminado con exito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror('Error al eliminar el instituto', false);
        }

        return $response->getdata();
    }

    public function Consultar($data)
    {
        $datos = null;
        try {
            switch ($data["tipo_consulta"]) {
                case 1:
                    // Consulta por ID de instituto
                    $datos = InstitutoModel::where('id_instituto', $data["id_instituto"])->where('estado','A')->get();
                    break;
                case 2:
                    // Consulta por nombre de instituto
                    $datos = InstitutoModel::where('nombre', 'LIKE', '%' . $data["nombre"] . '%')->where('estado','A')->get();
                    break;
                case 3:
                    // Consulta por código de instituto
                    $datos = InstitutoModel::where('codigo', $data["codigo"])->where('estado','A')->get();
                    break;
                case 4:
                    $datos = InstitutoModel::where('estado','A')->get();
                    break;
            }
            $this->obj_tipo_respuesta->setdata($datos);
            log::alert(collect($datos));
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos, error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
}
