<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\InstitutoModel;
use Exception;

class InstitutoServicio
{
    protected $obj_instituto_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_instituto_modelo = new InstitutoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateInstituto($institutoData)
        {
            try {
                //crear nuevo instituto
                $nuevoInstituto = new InstitutoModel();
                $nuevoInstituto->nombre = $institutoData['nombre'];
                $nuevoInstituto->codigo = $institutoData['codigo'];
                
                $nuevoInstituto->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoInstituto);

            } catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al crear el instituto', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateInstituto($institutoData)
        {
            try {
                //se busca el insituto a editar utilizando el modelo InstitutoModel
                $instituto = InstitutoModel::findOrFail($institutoData['id_instituto']);

                $instituto->nombre = $institutoData['nombre'];
                $instituto->codigo = $institutoData['codigo'];

                $instituto->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($instituto);
            }catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el instituto', false);
            }

            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteInstituto($institutoData)
        {
            try {
                //se busca el instituto a eliminar
                $instituto = InstitutoModel::findOrFail($institutoData);

                //eliminar instituto
                $instituto->estado = 'I';
                $instituto->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata(null);// no hay datos para devolver después de eliminar
            }catch (Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el instituto', false);
            }

            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de instituto
                        $datos = InstitutoModel::where('id_instituto', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por nombre de instituto
                        $datos = InstitutoModel::where('nombre', 'LIKE', '%' . $data["data"] . '%')->get();
                        break;
                    case 3:
                        // Consulta por código de instituto
                        $datos = InstitutoModel::where('codigo', $data["data"])->get();
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
