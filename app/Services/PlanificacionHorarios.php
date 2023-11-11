<?php

namespace App\service;

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
        } catch (Exception $e) {
            $this->obj_tipo_respuesta->setok(false);
            $this->obj_tipo_respuesta->seterror("Error al crear la Planificacion de Horarios", false);
        }
        return $this->obj_tipo_respuesta->getdata();
    }

    public function UpdatePlanificacion($horariosData)
    {
        try {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
                    $datos = PlanificacionHorarioModelo::where('id_planificacion_horarios', $data["data"])->get();
                    break;
                case 2:
                    // Consulta por ID de asignatura
                    $datos = PlanificacionHorarioModelo::where('id_asignatura', $data["data"])->get();
                    break;
                case 3:
                    // Consulta por ID de nivel
                    $datos = PlanificacionHorarioModelo::where('id_nivel', $data["data"])->get();
                    break;
                case 4:
                    // Consulta por ID de paralelo
                    $datos = PlanificacionHorarioModelo::where('id_paralelo', $data["data"])->get();
                    break;
                case 5:
                    // Consulta por ID de día
                    $datos = PlanificacionHorarioModelo::where('id_dia', $data["data"])->get();
                    break;
                case 6:
                    // Consulta por ID de período electivo
                    $datos = PlanificacionHorarioModelo::where('id_periodo_electivo', $data["data"])->get();
                    break;
                case 7:
                    // Consulta por ID de administración académica
                    $datos = PlanificacionHorarioModelo::where('id_administracion_academica', $data["data"])->get();
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
