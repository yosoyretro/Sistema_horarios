<?php

namespace App\services;

use App\Http\Responses\TypeResponse;
use App\Models\CarreraModel;
use App\Services\MensajeAlertasServicio;
use Illuminate\Support\Facades\Log;

use Exception;

class CarreraServicio
{
    protected $obj_carrera_modelo;
    protected $obj_tipo_respuesta;
    protected $obj_mensajes_alerta;
    public function __construct()

    {
        $this->obj_carrera_modelo = new CarreraModel();
        $this->obj_tipo_respuesta = new TypeResponse();
        $this->obj_mensajes_alerta = new MensajeAlertasServicio();
    }

    public function CreateCarrera($carreraData)
    {
        try {

            //crear nueva carrera
            $nueva_carrera = $this->obj_carrera_modelo::create([
                "codigo" => $carreraData['codigo'],
                "nombre" => $carreraData['nombre'],
                "estado" => "A",
                "created_at" => now(),
                "updated_at" => now()
            ]);
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($nueva_carrera);
        } catch (Exception $e) {
            log::alert("Soy el codigo " . $e->getCode());
            $servicio = $this->obj_mensajes_alerta->consultar(1, ["codigo" => $e->getCode()]);
            log::alert($servicio);
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror($servicio["data"][0]->mensaje, false);
        }

        return $this->obj_tipo_respuesta->getdata();
    }

    public function UpdateCarrera($carreraData)
    {
        try {
            $carrera = $this->obj_carrera_modelo::where("id_carrera", $carreraData["id_carrera"])->where("estado", "A")->update([
                "codigo" => $carreraData["codigo"],
                "nombre" => $carreraData["nombre"],
                "updated_at" => now()
            ]);
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($carrera);
            $servicio = $this->obj_mensajes_alerta->consultar(1, ["codigo" =>"2000"]);
            $this->obj_tipo_respuesta->setmensagge($servicio["data"][0]->mensaje);

        } catch (Exception $e) {
            log::alert("Soy el servicio de updateCarrera");
            log::alert("Soy el error : " . $e->getMessage());
            log::alert("Soy el codigo : " . $e->getCode());
            $this->obj_tipo_respuesta->setok(false);
            $servicio = $this->obj_mensajes_alerta->consultar(1, ["codigo" => $e->getCode()]);
            $this->obj_tipo_respuesta->seterror($servicio["data"][0]->mensaje, false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function DeleteCarrera($carreraData)
    {
        try {
            //se busca la carrera a eliminar
            $carrera = CarreraModel::findOrFail($carreraData);
            $carrera->estado = 'I';
            $carrera->save();

            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata(null); // no hay datos para devolver después de pasar a inactivo
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar la carrera', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function Consultar($data)
    {
        $datos = null;
        try {
            switch ($data["tipo_consulta"]) {
                case 1:
                    // Consulta por ID de carrera
                    $datos = CarreraModel::where('id_carrera', $data["data"])->get();
                    break;
                case 2:
                    // Consulta por nombre de carrera
                    $datos = CarreraModel::where('nombre', 'LIKE', '%' . $data["data"] . '%')->get();
                    break;
                case 3:
                    // Consulta por código de carrera
                    $datos = CarreraModel::where('codigo', 'LIKE' , '%' .$data["data"] . '%')->get();
                    break;
                case 4:
                    $datos = CarreraModel::where('estado',"A")->get();
                    break;
                case 5:
                    //consulta por el nombre y codigo
                    $datos = CarreraModel::where('codigo','LIKE',$data["codigo"])->where('nombre','LIKE',$data["nombre"])->get();
                    break;
               
            }
            $this->obj_tipo_respuesta->setdata($datos);
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Lo sentimos, error en el servicio', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
}
