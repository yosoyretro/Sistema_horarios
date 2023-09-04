<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\RolModel;
use Exception;

class RolServicio
{
    protected $obj_rol_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_rol_modelo = new RolModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
    public function Create($rolData)
    {
        try {
            //crear nuevo rol
            $nuevoRol = new RolModel();
            $nuevoRol->descripcion = $rolData['descripcion'];
            $nuevoRol->save();
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($nuevoRol);
        }catch(Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror("Error al crear el Rol", false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function Update($rolData)
    {
        try{
            $rol = RolModel::findOrFail($rolData['id_rol']);
            $rol->descripcion= $rolData['descripcion'];
            $rol->save();
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($rol);
        }catch(Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al editar el rol', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
    
    public function Delete($rolData)
    {
        try {
            $rol = RolModel::findOrFail($rolData);
            $rol->estado = 'I';
            $rol->save();
            $this->obj_tipo_respuesta->setok(true);
            $this->obj_tipo_respuesta->setdata($rol);
        }catch(Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror('Error al eliminar el rol', false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }
    
    public function Consultar()
    {
        $datos = RolModel::where('estado','A')->get();
        $this->obj_tipo_respuesta->setok(true);
        $this->obj_tipo_respuesta->setdata($datos);
        return $this->obj_tipo_respuesta->getdata();
    }

}