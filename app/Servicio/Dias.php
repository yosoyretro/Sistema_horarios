<?php

namespace App\Servicio;

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
            //
        }


        
}
