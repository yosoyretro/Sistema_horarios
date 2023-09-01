<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\ContolPermisoModel;
use Exception;

class Control_PermisosServicio
{
    protected $obj_permisos_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_permisos_modelo = new ContolPermisoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateControl($controlData)
        {
            try {
                //crear nuevo control de permisos
                $nuevoControl = new ContolPermisoModel();
                $nuevoControl->id_rol = $controlData['id_rol'];
                $nuevoControl->id_permiso = $controlData['id_permiso'];

                $nuevoControl->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoControl);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el control de permisos", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateControl($controlData)
        {
            try{
                $controlPermisos = ContolPermisoModel::findOrFail($controlData['id_control_permisos']);

                $controlPermisos->id_rol = $controlData['id_rol'];
                $controlPermisos->id_permiso = $controlData['id_permiso'];

                $controlPermisos->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($controlPermisos);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el control de permisos', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteControl($controlData)
        {
            try {
                $controlPermisos = ContolPermisoModel::findOrFail($controlData);

                $controlPermisos->estado = 'I';
                $controlPermisos->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($controlPermisos);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el control de permisos', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function ConsultarControl($data)
        {
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de control de permisos
                        $datos = ContolPermisoModel::findOrFail($data["data"]);
                        break;
                    case 2:
                        // Consulta por ID de rol y/o ID de permiso
                        $query = ContolPermisoModel::query();
                        
                        if (isset($data["id_rol"])) {
                            $query->where('id_rol', $data["id_rol"]);
                        }
                        
                        if (isset($data["id_permiso"])) {
                            $query->where('id_permiso', $data["id_permiso"]);
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
