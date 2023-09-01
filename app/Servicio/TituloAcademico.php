<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\TituloAcademicoModel;
use Exception;

class TituloAcademicoServicio
{
    protected $obj_titulo_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_titulo_modelo = new TituloAcademicoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreateTitulo($tituloData)
        {
            try {
                //crear nuevo titulo
                $nuevoTitulo = new TituloAcademicoModel();
                $nuevoTitulo->descripcion = $tituloData['descripcion'];
                $nuevoTitulo->codigo = $tituloData['codigo'];

                $nuevoTitulo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoTitulo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el Titulo academico", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdateTitulo($tituloData)
        {
            try{
                $titutloAcademico = TituloAcademicoModel::findOrFail($tituloData['id_titulo_academico']);

                $titutloAcademico->descripcion = $tituloData['descripcion'];
                $titutloAcademico->codigo = $tituloData['codigo'];

                $titutloAcademico->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($titutloAcademico);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el Titulo academico', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeleteTitulo($tituloData)
        {
            try {
                $titutloAcademico = TituloAcademicoModel::findOrFail($tituloData);

                $titutloAcademico->estado = 'I';
                $titutloAcademico->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($titutloAcademico);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el control de permisos', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function ConsultarTitulo($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de título académico
                        $datos = TituloAcademicoModel::findOrFail($data["data"]);
                        break;
                    case 2:
                        // Consulta por descripción o código
                        $query = TituloAcademicoModel::query();
                        
                        if (isset($data["descripcion"])) {
                            $query->where('descripcion', 'LIKE', '%' . $data["descripcion"] . '%');
                        }
                        
                        if (isset($data["codigo"])) {
                            $query->where('codigo', $data["codigo"]);
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
