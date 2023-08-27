<?php

namespace App\Http\Responses;

use Illuminate\Database\Eloquent\Collection;

class TypeResponse{

    protected $dicionario;

    public function __construct()
    {
        $this->dicionario = new Collection([
            'ok' => true,
            'msg' => '',
            'data'=>'',
            'msg_error' => '',
            'exception' => ''
        ]);

    }

    public function setok($mensaje){
        $this->dicionario["ok"]=$mensaje;            
    }

    public function setmensagge($mensaje){
        $this->dicionario["msg"]=$mensaje;
    }
    public function setdata($data){
        $this->dicionario["data"]=$data;
    }
    public function seterror($mensaje,$exception){
        $this->dicionario["msg_error"] = $mensaje;
        $this->dicionario["exception"] = $exception;
    }

    public function getdata(){
        return $this->dicionario;
    }


}