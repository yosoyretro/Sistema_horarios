<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\NivelModel;
use Exception;

class NivelServicio
{
    protected $obj_nivel_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_nivel_modelo = new NivelModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateNivel($nivelData)
        {
            try {
                //crear nuevo nivel
                $nuevoNivel = new NivelModel();
                $nuevoNivel->numero = $nivelData['numero'];
                $nuevoNivel->descripcion = $nivelData['descripcion'];

                $nuevoNivel->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoNivel);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el nivel", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateNivel($nivelData)
        {
            try{
                $nivel = NivelModel::findOrFail($nivelData['id_nivel']);

                $nivel->numero = $nivelData['numero'];
                $nivel->descripcion = $nivelData['descripcion'];

                $nivel->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nivel);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el nivel', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteNivel($nivelData)
        {
            try {
                $nivel = NivelModel::findOrFail($nivelData);

                $nivel->estado = 'I';
                $nivel->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nivel);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el nivel', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de nivel
                        $datos = NivelModel::where('id_nivel', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por número de nivel
                        $datos = NivelModel::where('numero', $data["data"])->get();
                        break;
                    case 3:
                        // Consulta por descripción de nivel
                        $datos = NivelModel::where('descripcion', 'LIKE', '%' . $data["data"] . '%')->get();
                        break;
                }
                $this->obj_tipo_respuesta->setdata($datos->first());
            } catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Lo sentimos, error en el servicio', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }


        
}
