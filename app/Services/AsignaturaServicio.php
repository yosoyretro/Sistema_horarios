<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\AsignaturaModel;
use Illuminate\Support\Facades\Log;
use Exception;

class AsignaturaServicio
{
    protected $obj_asignatura_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_asignatura_modelo = new AsignaturaModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }

    public function CreateAsignatura($asignaturaData)
    {


        $response = new TypeResponse();
        try {
            //crear nueva asignatura
            $nuevoAsignatura = $this->obj_asignatura_modelo::create(
                [
                    "codigo" => $asignaturaData["codigo"],
                    "descripcion" => $asignaturaData["descripcion"]
                ]
            );

            $response->setok(true);
            $response->setdata($nuevoAsignatura);
            $response->setmensagge("Asignatura creada con exito");
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror("Error al crear la asignatura", false);
        }
        return $response->getdata();
    }

    public function UpdateAsignatura($asignaturaData)
    {
        $response = new TypeResponse();

        try {

            $asignatura = AsignaturaModel::where("id_asignatura",$asignaturaData['id_asignatura'])
                ->update(
                    [
                        "codigo" => $asignaturaData['codigo'],
                        "descripcion" => $asignaturaData['descripcion'],
                        "updated_at" => now()
                    ]
                );
            $response->setok(true);
            $response->setdata($asignatura);
            $response->setmensagge("Asignatura editada con exito");
        } catch (Exception $e) {
            log::alert("ERROR : "  . $e->getMessage());
            $response->setok(false);
            $response->seterror('Error al editar la asignatura ', false);
        }
        return $response->getdata();
    }

    public function DeleteAsignatura($asignaturaData)
    {
        try {
            $asignatura = AsignaturaModel::findOrFail($asignaturaData);

            $asignatura->estado = 'I';
            $asignatura->save();

            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($asignatura);
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar la asignatura', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function Consultar($data)
    {
        $datos = null;
        $response = new TypeResponse();
        try {
            log::alert("PASO POR LA FUNCION DE CONSULTAR");
            switch ($data["tipo_consulta"]) {
                case 1:
                    // Consulta por ID de asignatura
                    $datos = AsignaturaModel::where('id_asignatura', $data["data"])->where("estado", "A")->get();
                    break;
                case 2:
                    // Consulta por descripción de asignatura
                    $datos = AsignaturaModel::where('descripcion', 'LIKE', $data["descripcion"])->where("estado", "A")->get();
                    break;
                case 3:
                    // Consulta por código de asignatura
                    $datos = AsignaturaModel::where('codigo', $data["codigo"])->where("estado", "A")->get();
                    break;
                case 4:
                    //consulta por el codigo y por el nombre
                    $datos = AsignaturaModel::where('codigo', 'LIKE', $data["codigo"])->where('descripcion', 'LIKE', $data["descripcion"])->where("estado", "A")->get();
                    break;
                case 5:
                    //consulta por el codigo o por el nombre
                    $datos = AsignaturaModel::where('codigo', 'LIKE', $data["codigo"])->orWhere('descripcion', 'LIKE', $data["descripcion"])->where("estado", "A")->get();
                    break;
                case 6:
                    //consulta por todo por el id por el nombre y por codigo
                    $datos = AsignaturaModel::where('id_asignatura', $data["id_asignatura"])->where('codigo', 'LIKE', $data["codigo"])->Where('descripcion', 'LIKE', $data["descripcion"])->where("estado", "A")->get();
                    break;
                case 7:
                    //consulta todo los registro por el estado activo
                    $datos = AsignaturaModel::where('Estado','A')->get();
                    break;
            }
            $this->obj_tipo_respuesta->setdata($datos);
        } catch (Exception $e) {
            $response->setok(false);
            $response->setmensagge($e->getMessage(), $e->getLine());
            $response->setok(false);
            $response->seterror('Lo sentimos, error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
}
