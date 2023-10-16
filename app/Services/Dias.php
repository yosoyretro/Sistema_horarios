<?php

namespace App\service;

use App\Http\Responses\TypeResponse;
use App\Models\DiasModel;
use Exception;

class DiasServicio
{
    protected $obj_dias_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_dias_modelo = new DiasModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateDias($diasData)
        {
            try {
                //crear nuevo dias
                $nuevoDia = new DiasModel();
                $nuevoDia->dia = $diasData['dia'];

                $nuevoDia->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoDia);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el dia", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateDias($diasData)
        {
            try{
                $dias = DiasModel::findOrFail($diasData['id_dias']);

                $dias->dia= $diasData['dia'];

                $dias->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($dias);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el dia', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteDias($diasData)
        {
            try {
                $dias = DiasModel::findOrFail($diasData);

                $dias->estado = 'I';
                $dias->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($dias);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el dia', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de días
                        $datos = DiasModel::where('id_dias', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por nombre de día
                        $datos = DiasModel::where('dia', 'LIKE', '%' . $data["data"] . '%')->get();
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
