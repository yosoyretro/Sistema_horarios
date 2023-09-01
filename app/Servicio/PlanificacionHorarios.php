<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\PlanificacionHorarioModelo;
use Exception;

class PlanificacionHorariosServicio
{
    protected $obj_planificacion_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_planificacion_modelo = new PlanificacionHorarioModelo();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreatePlanificacion($horariosData)
        {
            try {
                //crear nueva Planificacion de Horarios
                $nuevaPlanificación = new PlanificacionHorarioModelo();
                $nuevaPlanificación->id_asignatura = $horariosData['id_asignatura'];
                $nuevaPlanificación->id_nivel = $horariosData['id_nivel'];
                $nuevaPlanificación->id_paralelo = $horariosData['id_paralelo'];
                $nuevaPlanificación->id_dias = $horariosData['id_dias'];
                $nuevaPlanificación->id_periodo_electivo = $horariosData['id_periodo_electivo'];
                $nuevaPlanificación->id_administracion_academica = $horariosData['id_administracion_academica'];
                $nuevaPlanificación->inicia = $horariosData['inicia'];
                $nuevaPlanificación->termina = $horariosData['termina'];

                $nuevaPlanificación->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevaPlanificación);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear la Planificacion de Horarios", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdatePlanificacion($horariosData)
        {
            try{
                $planificacionAcademica = PlanificacionHorarioModelo::findOrFail($horariosData['id_planificacion_horarios']);

                $planificacionAcademica->id_asignatura = $horariosData['id_asignatura'];
                $planificacionAcademica->id_nivel = $horariosData['id_nivel'];
                $planificacionAcademica->id_paralelo = $horariosData['id_paralelo'];
                $planificacionAcademica->id_dias = $horariosData['id_dias'];
                $planificacionAcademica->id_periodo_electivo = $horariosData['id_periodo_electivo'];
                $planificacionAcademica->id_administracion_academica = $horariosData['id_administracion_academica'];
                $planificacionAcademica->inicia = $horariosData['inicia'];
                $planificacionAcademica->termina = $horariosData['termina'];

                $planificacionAcademica->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($planificacionAcademica);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar la Planificacion de Horarios', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeletePlanificacion($horariosData)
        {
            try {
                $planificacionAcademica = PlanificacionHorarioModelo::findOrFail($horariosData);

                $planificacionAcademica->estado = 'I';
                $planificacionAcademica->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($planificacionAcademica);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar la Planificacion de Horarios', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function Consultar($data)
        {
            $datos = null;
            try {
                switch ($data["tipo_consulta"]) {
                    case 1:
                        // Consulta por ID de planificación de horarios
                        $datos = PlanificacionHorarioModelo::findOrFail($data["data"]);
                        break;
                    case 2:
                        // Consulta por diferentes criterios de búsqueda
                        $query = PlanificacionHorarioModelo::query();
                        
                        if (isset($data["id_asignatura"])) {
                            $query->where('id_asignatura', $data["id_asignatura"]);
                        }
                        
                        if (isset($data["id_nivel"])) {
                            $query->where('id_nivel', $data["id_nivel"]);
                        }
                        
                        if (isset($data["id_paralelo"])) {
                            $query->where('id_paralelo', $data["id_paralelo"]);
                        }
                        
                        if (isset($data["id_dia"])) {
                            $query->where('id_dia', $data["id_dia"]);
                        }
                        
                        if (isset($data["id_periodo_electivo"])) {
                            $query->where('id_periodo_electivo', $data["id_periodo_electivo"]);
                        }
                        
                        if (isset($data["id_administracion_academica"])) {
                            $query->where('id_administracion_academica', $data["id_administracion_academica"]);
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
