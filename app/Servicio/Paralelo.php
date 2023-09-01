<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\ParaleloModel;
use Exception;

class ParaleloServicio
{
    protected $obj_paralelo_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_paralelo_modelo = new ParaleloModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateParalelo($paraleloData)
        {
            try {
                //crear nuevo paralelo
                $nuevoParalelo = new ParaleloModel();
                $nuevoParalelo->paralelo = $paraleloData['numero'];

                $nuevoParalelo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoParalelo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el paralelo", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateParalelo($paraleloData)
        {
            try{
                $paralelo = ParaleloModel::findOrFail($paraleloData['id_paralelo']);

                $paralelo->paralelo= $paraleloData['paralelo'];

                $paralelo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($paralelo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el paralelo', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteParalelo($paraleloData)
        {
            try {
                $paralelo = ParaleloModel::findOrFail($paraleloData);

                $paralelo->estado = 'I';
                $paralelo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($paralelo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el paralelo', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            //
        }


        
}
