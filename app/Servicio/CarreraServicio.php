<?php

namespace App\Servicio;

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

        public function Delete($carreraData)
        {
            try {
                //se busca la carrera a eliminar
                $carrera = CarreraModel::findOrFail($carreraData);
                
                $carrera->estado = 'I';
                $carrera->delete();
                
                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata(null);// no hay datos para devolver después de eliminar
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
                switch($data["tipo_consulta"]){
                    case 1:
                        //consula por código
                        $datos = CarreraModel::where('codigo', $data["data"])->get();
                    case 2:
                        $datos = CarreraModel::where('nombre', 'LIKE', '%' . $data["data"] . '%')->get();
                }
                $this->obj_tipo_respuesta->setdata($datos[0]);

            }catch (Exception $e) {
                $this-> obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Lo sentimos error en la consulta', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }


        
}
