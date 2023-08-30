<?php

namespace App\Servicio;

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

        public function Consultar($data)
        {
            try {

            }catch(Exception $e) {

            }
            return ;
        }


        
}
