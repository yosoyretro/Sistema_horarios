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

    public function CreateAsignatura(array $asignaturaData)
    {
        $response = new TypeResponse();
        try {
            if(!AsignaturaModel::insert([
                "codigo"=>$asignaturaData["codigo"],
                "descripcion"=>strtoupper($asignaturaData["descripcion"]),
                "ip_creacion"=>"192.168.14.13"
            ]))throw new Exception("A ocurrido un error al crear la asignatura");
            $response->setok(true);
            $response->setmensagge("La asignatura " . strtoupper($asignaturaData["descripcion"]) . " se creo con exito");

        } catch (Exception $e) {
            log::alert("MOTIVO : " . $e->getMessage());
            log::alert("LINEA : " . $e->getLine());
            $mensaje = "";

            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace Falta un campo";
                    break;
                case '23000':
                    $mensaje = "En el registro ya existe un campo que tiene ese mismo mismo datos en otro registro, recordar que los datos no se pueden repetir en ningun registro";
                    break;
                default:
                    $mensaje = $e->getMessage();
                    break;
            };

            log::alert("El error esta en el servicio ");
            log::alert("Mensaje : " . $e->getMessage());
            log::alert("Linea : " . $e->getLine());
            $response->setok(false);
            $response->seterror($mensaje, false);
        }
        return $response->getdata();
    }

    public function UpdateAsignatura($asignaturaData)
    {
        $response = new TypeResponse();

        try {
            if(!AsignaturaModel::where("id_materia",$asignaturaData['id_asignatura'])
                ->update(
                    [
                        "codigo" => $asignaturaData['codigo'],
                        "descripcion" => $asignaturaData['descripcion'],
                        "fecha_actualizacion" => now()->format('Y-m-d'),
                        "hora_actualizacion" => now()->format('H:i:s'),
                    ]
                ))throw new Exception("A ocurrido un error en el servicio ");

            $response->setok(true);
            $response->setdata(0);
            $response->setmensagge("Asignatura editada con exito");
        } catch (Exception $e) {
            $mensaje = "";
            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace Falta un campo";
                    break;
                case '23000':
                    $mensaje = "En el registro ya existe un campo que tiene ese mismo mismo datos en otro registro, recordar que los datos no se pueden repetir en ningun registro";
                    break;
                default:
                    $mensaje = $e->getMessage();
                    break;
            };
            $response->seterror($mensaje,$e->getCode());
            $response->setok(false);
            $response->seterror($mensaje,$e->getCode());
        }
        return $response->getdata();
    }

    public function DeleteAsignatura($asignaturaData)
    {
        try {
            $asignatura = AsignaturaModel::findOrFail($asignaturaData)->update([
                "codigo" => "E" . random_int(1, 500)." - ". now(),
                "descripcion" => "E" . random_int(1, 500)." - ". now(),
                "estado" => "E",
                "fecha_actualizacion" => now()->format('Y-m-d'),
                "hora_actualizacion" => now()->format('H:i:s'),
            ]);

            $this->obj_tipo_respuesta->setok(true);
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
            log::alert("A ocurrido un error en obtener la informacion");
            log::alert("MENSAJE : " . $e->getMessage());
            log::alert("LINEA : " . $e->getLine());

            $response->setok(false);
            $response->setmensagge($e->getMessage(), $e->getLine());
            $response->setok(false);
            $response->seterror('Lo sentimos, error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
}
