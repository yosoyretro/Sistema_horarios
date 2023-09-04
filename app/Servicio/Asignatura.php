<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\AsignaturaModel;
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
            try {
                //crear nueva asignatura
                $nuevoAsignatura = new AsignaturaModel();
                $nuevoAsignatura->descripcion = $asignaturaData['descripcion'];
                $nuevoAsignatura->codigo = $asignaturaData['codigo'];

                $nuevoAsignatura->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoAsignatura);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear la asignatura", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateAsignatura($asignaturaData)
        {
            try{
                $asignatura = AsignaturaModel::findOrFail($asignaturaData['id_asignatura']);

                $asignatura->descripcion = $asignaturaData['descripcion'];
                $asignatura->codigo = $asignaturaData['codigo'];

                $asignatura->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($asignatura);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar la asignatura', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteAsignatura($asignaturaData)
        {
            try {
                $asignatura = AsignaturaModel::findOrFail($asignaturaData);

                $asignatura->estado = 'I';
                $asignatura->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($asignatura);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar la asignatura', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de asignatura
                        $datos = AsignaturaModel::where('id_asignatura', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por descripción de asignatura
                        $datos = AsignaturaModel::where('descripcion', 'LIKE', '%' . $data["data"] . '%')->get();
                        break;
                    case 3:
                        // Consulta por código de asignatura
                        $datos = AsignaturaModel::where('codigo', $data["data"])->get();
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
