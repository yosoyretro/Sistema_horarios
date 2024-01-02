<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\TituloAcademicoModel;
use Illuminate\Support\Facades\Log;
use Exception;

class TituloAcademicoServicio
{

    public function CreateTitulo(array $tituloData)
    {
        $response = new TypeResponse();
        try {
            if(!TituloAcademicoModel::insert([
                "codigo"=>$tituloData["codigo"],
                "descripcion"=>strtoupper($tituloData["descripcion"]),
                "nemonico"=>strtoupper($tituloData["nemonico"]),
                "ip_creacion"=>"192.168.14.13"
            ]))throw new Exception("A ocurrido un error al crear el titutlo academico " . strtoupper($tituloData["descripcion"]));
            
            $response->setmensagge("Titulo Creado con existo");
        } catch (Exception $e) {
            $mensaje = "";
            switch ($e->getCode()) {
                case 'HY000':
                    $mensaje = "Hace Falta un campo";
                    break;
                case '23000':
                    $mensaje = "En el registro ya existe un dato que tiene ese mismo mismo datos , recordar que los datos no se pueden repetir en ningun registro";
                    break;
                default:
                    $mensaje = "A ocurrido un error al crear el titutlo academico";
                    break;
            };
            $response->setok(false);
            $response->seterror($mensaje,$e->getCode());
        }
        return $response->getdata();
    }

    public function UpdateTituloAcademico($array_asociativo)
    {
        $response = new TypeResponse();
        try {
            log::alert("Paso por la funcion de actualizar el titutlo academico ");
            $titulo_academico = TituloAcademicoModel::where("id_titulo_academico", $array_asociativo["id_titulo_academico"])->update(
                [
                    "codigo" => $array_asociativo["codigo"],
                    "nemonico" => strtoupper($array_asociativo["nemonico"]),
                    "descripcion" => strtoupper($array_asociativo["descripcion"]),
                    "fecha_actualizacion" => now()->format('Y-m-d'),
                    "hora_actualizacion" => now()->format('H:i:s'),
                ]
            );
            $response->setdata($titulo_academico);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
            log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }

    public function consultarTitulo($opcion, $data = null)
    {
        $datos = null;

        try {
            $response = new TypeResponse();
            switch ($opcion) {
                case 1:
                    // Consulta por ID de título académico
                    $datos = TituloAcademicoModel::where('id_titulo_academico', $data["id_titulo_academico"])->where("estado", "A")->get();
                    break;
                case 2:
                    // Consulta por descripción de título académico
                    $datos = TituloAcademicoModel::where('descripcion', 'LIKE', '%' . $data["descripcion"] . '%')->where("estado", "A")->get();
                    break;
                case 3:
                    // Consulta por código de título académico
                    $datos = TituloAcademicoModel::where('codigo', $data["codigo"])->where("estado", "A")->get();
                    break;
                case 4:
                    //Consulta por todo todos los datos 
                    break;
                case 5:
                    //consultar por codigo o por descripcion
                    $datos =  TituloAcademicoModel::where("estado", "A")
                        ->where(function ($query) use ($data) {
                            $query->where('codigo', $data["codigo"])
                                ->orWhere('descripcion', $data["descripcion"]);
                        })
                        ->get();
                    break;
                case 6:
                    //consultar por estado 
                    $datos = TituloAcademicoModel::where("estado","A")->get();
                    break;
                case 7:
                    //consultar por todo 
                    $datos = TituloAcademicoModel::whereIn('estado',['A','I'])->get();
                    break;
            }
            $response->setdata($datos);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror("A ocurrido un error en la consulta el Titulo Academico", $e->getMessage());
        }
        return $response->getdata();
    }

    public function deleteTituloAcademico($id_titulo_academico)
    {
        try {
            $response = new TypeResponse();
            $titulo_academico = TituloAcademicoModel::where("id_titulo_academico", $id_titulo_academico)->update(
                [
                    "codigo" => "E" . random_int(1, 500)." - ". now(),
                    "nemonico" => "E" . random_int(1, 500)." - ". now(),
                    "descripcion" => "E" . random_int(1, 500)." - ". now(),
                    "estado" => "E",
                    "fecha_actualizacion" => now()->format('Y-m-d'),
                    "hora_actualizacion" => now()->format('H:i:s'),
                ]
            );
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(), $e->getLine());
            log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }
}
