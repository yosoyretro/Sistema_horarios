<?php

namespace App\Servicio;

use App\Http\Responses\TypeResponse;
use App\Models\PeriodoElectivoModel;
use Exception;

class PeriodoElectivoServicio
{
    protected $obj_periodo_modelo;
    protected $obj_tipo_respuesta;
    public function __construct()
    {
        $this->obj_periodo_modelo = new PeriodoElectivoModel();
        $this->obj_tipo_respuesta = new TypeResponse();
    }
    
        public function CreatePeriodo($periodoData)
        {
            try {
                //crear nuevo periodo electivo
                $nuevoPeriodo = new PeriodoElectivoModel();
                $nuevoPeriodo->fecha_inicio = $periodoData['fecha_inicio'];
                $nuevoPeriodo->fecha_termina = $periodoData['fecha_termina'];

                $nuevoPeriodo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($nuevoPeriodo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror("Error al crear el periodo electivo", false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function UpdatePeriodo($periodoData)
        {
            try {
                $periodoElectivo = PeriodoElectivoModel::findOrFail($periodoData['id_periodo_electivo']);

                $periodoElectivo->fecha_inicio = $periodoData['fecha_inicio'];
                $periodoElectivo->fecha_termina = $periodoData['fecha_termina'];

                $periodoElectivo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($periodoElectivo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al editar el periodo electivo', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function DeletePeriodo($periodoData)
        {
            try {
                $periodoElectivo = PeriodoElectivoModel::findOrFail($periodoData);

                $periodoElectivo->estado = 'I';
                $periodoElectivo->save();

                $this->obj_tipo_respuesta->setok(true);
                $this->obj_tipo_respuesta->setdata($periodoElectivo);
            }catch(Exception $e) {
                $this->obj_tipo_respuesta->setok(false);
                $this->obj_tipo_respuesta->seterror('Error al eliminar el periodo electivo', false);
            }
            return $this->obj_tipo_respuesta->getdata();
        }

        public function ConsultarPeriodo($data)
        {
            try {

            }catch(Exception $e) {

            }
            return ;
        }


        
}
