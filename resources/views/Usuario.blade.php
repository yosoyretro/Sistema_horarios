@extends('aside')

@section('titulo','Usuario')

@section('contenido')
<div class="card mb-4 m-2 border">
    <div class="card-header" style="background:#3f4bb9;">
        <div class="col-auto">
            <span>
                <p class="m-3 lead text-white"><i class="fas fa-table me-1 text-white pr-3"></i>Lista de usuarios registrado en el sistema</p>
            </span>
        </div>
        <di class="container">
            <button type="button" class="btn fondo-istgs text-white border-white" data-bs-target="#usuario" data-bs-toggle="modal"><i class="fas fa-user-plus"></i>crear usuario</button>
        </di>

    </div>

    <div class="card-body">
        <table class="table texto-dark text-center table-bordered table-white justify-content-end">
            <thead class="fondo-istg text-white">

                <tr>
                    <th>Cedula</th>
                    <th>Nombres y Apellidos</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Fecha - creacion</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody class="bg-light text-black font-lg">
                @if(!count($usuarios_datos[0]) == 0)
                    
                    @foreach($usuarios_datos[0] as $indice => $data)
                        <tr>
                            <th>{{$data->cedula}}</th>
                            <th>{{$data->nombres}}</th>
                            <th>{{$data->usuario}}</th>
                            <th>{{$data->ROL->descripcion}}</th>
                            <th>{{$data->FECHA_CREACION}}</th>
                            <th>
                                <button class="btn btn-warning text-white" data-toggle="modal" data-target="#editar-usuario"><strong><i class="fas fa-pencil-alt"></i></strong></button>
                                <button class="btn btn-danger" onclick="mensaje_eliminar({{$data->id_usuario}},1)"><strong><i class="fas fa-trash"></i></strong></button>
                            </th>


                        </tr>
                    @endforeach
                @else
                    <th colspan="20">
                        <img class="img-icons-m" src="{{ asset('icons/vacio.png') }}">
                        <p><strong>No hay usuarios registrados</strong></p>
                    </th>
                @endif



            </tbody>
        </table>

    </div>
</div>

<!--MODALS-->


<div class="modal fade" id="usuario" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header text-white" style="background-color: #3f4bb9;">
                <h5 class="modal-title text-white" id="exampleModalLabel"><i class="fas fa-user-plus text-white pr-3"></i>Añadir un usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('crear_usuario') }}" method="POST" id="datos-formulario" >
                @csrf
                <div class="modal-body font-lg">
                    <div class="form-group">
                        <label class="form-label ">Ingrese el numero de cedula </label>
                        <input type="number" style="font-size: 12px;" id="numero" name="numero" class="form-control font-lg">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ingrese sus nombres y apellidos</label>
                        <input type="text" class="form-control" style="font-size: 12px;" rows="2" id="nombres" name="nombres"></input>
                    </div>

                    <div class="form-group" >
                        <label class="form-label">Seleccione el rol</label>
                        <select class="form-control"  style="font-size: 12px;" name="rol">
                            <option selected hidden>Escoja el rol que va a desempeñar el usuario</option>
                            @foreach($rol_datos as $rol)
                                <option value="{{$rol->id_rol}}">{{$rol->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button name="adjuntar" type="submit" class="btn w-100 border-white text-white" style="background:#3f4bb9;"><i class="fas fa-save pr-2"></i>Crear Usuario</button>
                </div>

            </form>
            
        </div>
    </div>
</div>

@endsection