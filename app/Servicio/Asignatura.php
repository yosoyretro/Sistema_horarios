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
    
        public function Create($asignaturaData)
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

        public function Update($asignaturaData)
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

        public function Delete($asignaturaData)
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
                        $datos = AsignaturaModel::findOrFail($data["data"]);
                        break;
                    case 2:
                        // Consulta por descripción o código
                        $query = AsignaturaModel::query();
                        
                        if (isset($data["descripcion"])) {
                            $query->where('descripcion', 'LIKE', '%' . $data["descripcion"] . '%');
                        }
                        
                        if (isset($data["codigo"])) {
                            $query->where('codigo', $data["codigo"]);
                        }
                        
                        $datos = $query->get();
                        break;
                    default:
                        $this->obj_tipo_respuesta->setok(false);
                        $this->obj_tipo_respuesta->seterror('Tipo de consulta inválido', false);
                        return $this->obj_tipo_respuesta->getdata();
                }
        
                // Configurar la respuesta exitosa en el objeto TypeResponse
                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($datos);
            } catch (Exception $e) {
                // Configurar la respuesta de error en el objeto TypeResponse
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error en el servicio de consulta', false);
            }
        
            return $this->obj_tipo_respuesta->getdata();
        }


        
}
