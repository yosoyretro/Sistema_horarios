<?php

namespace App\Http\Controllers;

use App\Models\TituloAcademicoModel;
use Illuminate\Http\Request;
use App\Http\Responses\TypeResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use App\Servicio\TituloAcademicoServicio;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Log;
use PhpParser\Builder\Function_;

class TituloAcademicoController extends Controller
{
    protected $tituloacademicoServicio;
 
    public function __construct(TituloAcademicoServicio $tituloAcademicoServicio)
    {
        $this->tituloacademicoServicio = $tituloAcademicoServicio;
    }
 
    //VISTA DEL TITULO ACADEMICO
    public function showTituloAcademicoForm(){
        $mensajes_titulo = session('data');
        return view('titulo', compact('mensajes_titulo'));

    }

    //CONTROLADOR TITULO-ACADEMICO
    public function TituloAcademicoController(Request $request){
        $descripcion = $request->input('descripcion');
        $codigo = $request->input('codigo');

        //VALIDACION DE DATOS DEL FORMULARIO DE TITULO ACADEMICO
        $request->validate([
            'descripcion' => 'required|string',
            'codigo' => 'required|string'
        ]);
        
         // Crear título académico
         $data = [
            'descripcion' => $descripcion,
            'codigo' => $codigo
         ];
        
        $obj_tipo_respuesta = new TypeResponse();

        $tituloacademicoServicio = new TituloAcademicoServicio();
        $respuesta = $this->tituloacademicoServicio->CreateTitulo($data);

        if ($respuesta['ok'] && $respuesta['data']->descripcion === $descripcion && $respuesta['data']->codigo === $codigo){
            
            return redirect(route('tituloacademico')); 
        }else {
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setmensagge('Datos de Titulo Academico invalidos');
        }

        return redirect(route('tituloacademico'))->with('data', $obj_tipo_respuesta->getdata());
    }   

    // Crear TITULO ACADEMICO
    public function createTituloAcademico(Request $request){
     
        $descripcion = $request->input('descripcion');
        $codigo = $request->input('codigo');

        //VALIDACION DE DATOS DEL FORMULARIO DE TITULO ACADEMMICO
        $request->validate([
            'descripcion' => 'required|string',
            'codigo' => 'required|string'
        ]);

        //CREAR TITULO ACADEMICO
        $data = [
            'descripcion' => $descripcion,
            'codigo' => $codigo
        ];

        $respuesta = $this->tituloacademicoServicio->CreateTitulo($data);

        if ($respuesta['ok'] && $respuesta['data']->descripcion === $descripcion && $respuesta['data']->codigo === $codigo) {
            return redirect(route('tituloacademico'));
        }else {
            $obj_tipo_respuesta = new TypeResponse();
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setmensagge('Datos de Titulo Academico Invalidos');

            return redirect(route('tituloacademico'))->with('data', $obj_tipo_respuesta->getdata());
        }
    }

    // ACTUALIZAR TITULO ACADEMICO
    public function updateTituloAcademico(Request $request){
        $idTituloAcademico = $request->input('id_titulo_academico');
        $descripcion = $request->input('descripcion');
        $codigo = $request->input('codigo');

        //VALIDACION DE DATOS DEL FORMULARIO  DE ACTUALIZACION DE TITULO ACADEMICO
        $request->validate([
            'id_titulo_academico' => 'required|string',
            'descripcion' => 'required|string',
            'codigo' => 'required|string'
        ]);

        //ACTUALIZAR TITULO ACADEMICO 
        $data = [
            'id_titulo_academico' => $idTituloAcademico,
            'descripcion' => $descripcion,
            'codigo' => $codigo
        ];

        $respuesta = $this->tituloacademicoServicio->UpdateTitulo($data);

        if ($respuesta['ok'] && $respuesta['data']->descripcion === $descripcion && $respuesta['data']->codigo === $codigo) {
            return redirect(route('tituloacademico'));
        }else {
            $obj_tipo_respuesta = new TypeResponse();
            $obj_tipo_respuesta->setok('false');
            $obj_tipo_respuesta->setmensagge('Error al actulizar el Titulo Academico');

            return redirect(route('tituloacademico'))->with('data', $obj_tipo_respuesta->getdata());
        }
        
    }
    
    //ELIMINAR TITULO ACADEMICO
    public function deleteTituloAcademico(Request $request){
        $idTituloAcademico = $request->input('id_titulo_academico');

        // VALIDACION DE DATOS PARA EL FORMMULARIO DE ELIMINACION DE TITULO ACADEMICO
        $request -> validate([
            'id_titulo_academico' => 'required|integer',
        ]);
        
        //ELIMINAR TITULO ACADEMICO
        $respuesta =$this->tituloacademicoServicio->DeleteTitulo($idTituloAcademico);
        
        if ($respuesta['ok']) {
            return redirect(route('tituloacademico'));
        }else {
            $obj_tipo_respuesta = new TypeResponse();
            $obj_tipo_respuesta->setok(false);
            $obj_tipo_respuesta->setmensagge('Error al eliminar el titulo academico');

            return redirect(route('tituloacademico'))->with('data', $obj_tipo_respuesta->getdata());
        }
    }

    //CONSULTAR TITULO ACADEMICO 
    public function consultarTituloAcademico(Request $request){

        $tipo_Consulta = $request->input('tipo_consulta');
        $data = $request->input('data');

        //VALIDACION DE DATOS DEL FORMULARIO DE CONSULTA DE TITULO ACADEMICO 
        $request->validate([
            'tipo_consulta'=> 'required|integer',
            'data' => 'required'
        ]);
    }
}
