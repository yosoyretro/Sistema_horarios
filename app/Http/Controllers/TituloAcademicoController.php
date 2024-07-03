<?php

namespace App\Http\Controllers;

use App\Services\TituloAcademicoServicio;
use Illuminate\Http\Request;

class TituloAcademicoController extends Controller
{
    protected $tituloAcademicoServicio;

    public function __construct(TituloAcademicoServicio $tituloAcademicoServicio)
    {
        $this->tituloAcademicoServicio = $tituloAcademicoServicio;
    }

    public function storeTituloAcademico(Request $request)
    {
        $tituloData = $request->all();
        $response = $this->tituloAcademicoServicio->CreateTitulo($tituloData);
        return response()->json($response, $response['ok'] ? 200 : 400);
    }

    public function updateTituloAcademico(Request $request, $id)
    {
        $tituloData = $request->all();
        $tituloData['id_titulo_academico'] = $id;
        $response = $this->tituloAcademicoServicio->UpdateTituloAcademico($tituloData);
        return response()->json($response, $response['ok'] ? 200 : 400);
    }

    public function showTituloAcademico(Request $request, $opcion)
    {
        $data = $request->all();
        $response = $this->tituloAcademicoServicio->consultarTitulo($opcion, $data);
        return response()->json($response, $response['ok'] ? 200 : 400);
    }

    public function deleteTituloAcademico($id)
    {
        $response = $this->tituloAcademicoServicio->deleteTituloAcademico($id);
        return response()->json($response, $response['ok'] ? 200 : 400);
    }
}
