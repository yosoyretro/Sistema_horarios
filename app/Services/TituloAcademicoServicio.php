<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\TituloAcademicoModel;
use Illuminate\Support\Facades\Log;
use Exception;

class TituloAcademicoServicio
{

    public function CreateTitulo($tituloData)
    {
        try {
            $response = new TypeResponse();
            $nuevoTitulo = TituloAcademicoModel::create([
                'descripcion' => $tituloData['descripcion'],
                'codigo' => $tituloData['codigo'],
                'estado' => 'A',
                'fecha_creacion' => now(),
                'fecha_actualizacion' => now(),
            ]);
            $response->setmensagge("Titulo Creado con existo");

            $response->setdata($nuevoTitulo->id_titulo_academico);
            
        } catch (Exception $e) {
            log::alert("Error: " . $e->getMessage());
            $response->setok(false);
            $response->seterror("A ocurrido un error al crear el Titulo academico", $e->getMessage());
        }
        return $response->getdata();
    }

    public function UpdateTituloAcademico($array_asociativo)
    {
        try {
            $response = new TypeResponse();
            $titulo_academico = TituloAcademicoModel::where("id_titulo_academico", $array_asociativo["id_titulo_academico"])->update(
                [
                    "codigo" => $array_asociativo["codigo"],
                    "descripcion" => $array_asociativo["descripcion"],
                    "fecha_actualizacion" => now()
                ]
            );
            $response->setdata($titulo_academico);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
            log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }

    public function consultarTitulo($opcion,$data=null)
    {
        $datos = null;
        
        try {
            $response = new TypeResponse();
            switch ($opcion) {
                case 1:
                    // Consulta por ID de título académico
                    $datos = TituloAcademicoModel::where('id_titulo_academico', $data["id_titulo_academico"])->where("estado","A")->get();
                    break;
                case 2:
                    // Consulta por descripción de título académico
                    $datos = TituloAcademicoModel::where('descripcion', 'LIKE', '%' . $data["descripcion"] . '%')->where("estado","A")->get();
                    break;
                case 3:
                    // Consulta por código de título académico
                    $datos = TituloAcademicoModel::where('codigo', $data["codigo"])->where("estado","A")->get();
                    break;
                case 4:
                    //Consulta por todo todos los datos 
                    break; 
                case 5:
                    //consultar por codigo o por descripcion
                    $datos =  TituloAcademicoModel::orWhere('codigo', $data["codigo"])
                    ->orWhere('descripcion',$data["descripcion"])
                    ->where("estado","A")->get();
                    break;     
                case 6:
                    //consultar por estado 
                    $datos = TituloAcademicoModel::where("estado","A")->get();
                    break;
            }
            
            $response->setdata($datos);
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror("A ocurrido un error en la consulta el Titulo Academico",$e->getMessage());
        }
        return $response->getdata();
    }

    public function deleteTituloAcademico($id_titulo_academico)
    {
        try {
            $response = new TypeResponse();
            $titulo_academico = TituloAcademicoModel::where("id_titulo_academico", $id_titulo_academico)->update(
                [
                    "estado" => "I",
                    "fecha_actualizacion" => now()
                ]
            );
        
        } catch (Exception $e) {
            $response->setok(false);
            $response->seterror($e->getMessage(),$e->getLine());
            log::alert("ERROR : " . $e->getMessage());
        }
        return $response->getdata();
    }
}
