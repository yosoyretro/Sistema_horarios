<?php

namespace App\Services;

use App\Http\Responses\TypeResponse;
use App\Models\AdministracionAcademicaModel;
use Exception;

class AdministracionAcademicaServicio
{
    protected $obj_administracion_model;
    protected$obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_administracion_model = new AdministracionAcademicaModel();
        $this->obj_tipo_respuesta = new TypeResponse;
    }
    
        public function CreateAdministracion($adData)
        {
            try{
                //crear nueva Administracion Academica
                $nuevaAdministracion = new AdministracionAcademicaModel();
                $nuevaAdministracion->id_carrera = $adData['id_carrera'];
                $nuevaAdministracion->id_instituto = $adData['id_instituto'];

                //guardar la administración academica en la base de datos
                $nuevaAdministracion->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevaAdministracion);
            }catch (Exception $e){
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al crear la administracion academica', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateAdministracion($adData)
        {
            try {
                //se busca la administracion de la carrera a editar utilizando el modelo AdministraciónCarreraModel
                $administracionCarrera = AdministracionAcademicaModel::findOrFail($adData['id_administracion_academica']);

                $administracionCarrera->id_carrera = $adData['id_carrera'];
                $administracionCarrera->id_instituto = $adData['id_instituto'];

                $administracionCarrera->save();
                
                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($administracionCarrera);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar la administracion academica', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteAdministracion($adData)
        {
            try {
                //se busca la administracion academica a eliminar
                $administracionCarrera = AdministracionAcademicaModel::findOrFail($adData);

                $administracionCarrera->estado = 'I';
                $administracionCarrera->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata(null);// no hay datos para devolver después de pasar a inactivo
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar la administracion academica',false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function ConsultarAdministracion($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de administración académica
                        $datos = AdministracionAcademicaModel::where('id_administracion_academica', $data["data"])->get();
                        break;
                    case 2:
                        // Consulta por ID de carrera
                        $datos = AdministracionAcademicaModel::where('id_carrera', $data["data"])->get();
                        break;
                    case 3:
                        // Consulta por ID de instituto
                        $datos = AdministracionAcademicaModel::where('id_instituto', $data["data"])->get();
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
