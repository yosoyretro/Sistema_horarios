<?php

namespace App\service;

use App\Http\Responses\TypeResponse;
use App\Models\CarreraModel;
use Exception;

class CarreraServicio
{
    protected $obj_carrera_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_carrera_modelo = new CarreraModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateCarrera($carreraData)
        {
            try {
                //crear nueva carrera
                $nuevaCarrera = new CarreraModel();
                $nuevaCarrera->nombre = $carreraData['nombre'];
                $nuevaCarrera->codigo = $carreraData['codigo'];

                $nuevaCarrera->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevaCarrera);

            }catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al crear la carrera', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateCarrera($carreraData)
        {
            try {
                //se busca la carrera a editar utilizando el modelo CarreraModel
                $carrera = CarreraModel::findOrFail($carreraData['id_carrera']);

                $carrera->nombre = $carreraData['nombre'];
                $carrera->codigo = $carreraData['codigo'];

                $carrera->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($carrera);
            }catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar la carrera', false);
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
                $this->obj_tipo_respuesta->setdata(null);// no hay datos para devolver después de pasar a inactivo
            }catch (Exception $e) {
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
                        $datos = CarreraModel::where('codigo', $data["data"])->get();
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
