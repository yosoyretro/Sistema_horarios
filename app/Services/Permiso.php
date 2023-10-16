<?php

namespace App\service;

use App\Http\Responses\TypeResponse;
use App\Models\PermisoModel;
use Exception;

class PermisoServicio
{
    protected $obj_permiso_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_permiso_modelo = new PermisoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreatePermiso($permisoData)
        {
            try {
                //crear nuevo permiso
                $nuevoPermiso = new PermisoModel();
                $nuevoPermiso->descripcion = $permisoData['descripcion'];

                $nuevoPermiso->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoPermiso);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el permiso", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdatePermiso($permisoData)
        {
            try{
                $permiso = PermisoModel::findOrFail($permisoData['id_permiso']);

                $permiso->descripcion= $permisoData['descripcion'];

                $permiso->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($permiso);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el permiso', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeletePermiso($permisoData)
        {
            try {
                $permiso = PermisoModel::findOrFail($permisoData);

                $permiso->estado = 'I';
                $permiso->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($permiso);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el permiso', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de permiso
                        $datos = PermisoModel::where('id_permiso', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por descripción de permiso
                        $datos = PermisoModel::where('descripcion', 'LIKE', '%' . $data["data"] . '%')->get();
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
