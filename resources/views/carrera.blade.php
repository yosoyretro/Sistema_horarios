@extends('aside')

@section('titulo', 'Carreras')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>
        <h2><img height="75px" src="{{ asset('#') }}">Carreras</h2>
        <div class="card p-2 card-bg">
            <div class="container-fluid">
                <div class="row pt-4">
                    <div class="col-3 input-group mb-3 ml-3">
                        <span class="input-group-text fondo-istg text-white" id="basic-addon1"><i
                                class="bi bi-search text-negita"></i></span>
                        <input type="search" class="form-control" placeholder="Buscar Carrera">
                    </div>
                </div>

                <div class="container">
                    <button class=" btn buton-istg text-white text-center mb-2" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="bi bi-person-plus-fill"></i>
                        <spanan>Nuevo registro</spanan>
                    </button>
                </div>

            </div>

            <div class="row">
                <table class="container table-white table-bordered text-center">
                    <thead>
                        <tr class="fondo-istg text-white">
                            <th class="p-2" scope="col">ID</th>
                            <th class="p-2" scope="col">Nombre de carrera</th>
                            <th class="p-2" scope="col">Ubicacion</th>
                            <th class="p-2" scope="col">Malla Curricular</th>
                            <th class="p-2" scope="col">Especialidad</th>
                            <th class="p-2" scope="col">Fecha de creacion</th>
                            <th class="p-2" scope="col">Fecha de modificacion</th>
                            <th class="p-2" scope="col" colspan="4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if (!empty($data[0]))
                            @foreach ($data as $dato)
                                <tr>
                                    <td class="texto-pequeño">{{ $dato->cedula }}</td>
                                    <td class="texto-pequeño">{{ $dato->nombres }}</td>
                                    <td class="texto-pequeño">{{ $dato->usuario }}</td>
                                    <td class="texto-pequeño">{{ $dato->rol->descripcion }}</td>
                                    @if (empty($dato->id_titulo_academico))
                                        <td class="texto-pequeño">No tiene titulo academico</td>
                                    @else
                                        <td>
                                            @foreach ($dato->id_titulo_academico as $valor)
                                                <strong>{{ $valor->descripcion }}</strong><br>
                                            @endforeach
                                        </td>
                                    @endif
                                    <td class="texto-pequeño">{{ $dato->created_at }}</td>
                                    <td class="texto-pequeño">{{ $dato->updated_at }}</td>
                                    <td class="p-2">
                                        <button class="btn buton-istg text-white ">Editar</button>
                                        <button class="btn btn-danger text-white"
                                            onclick="elimnarUser( {{ $dato->id_usuario }} )">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" rowspan="25" class="texto-pequeño text-danger">
                                    <h6><strong><i class="bi bi-archive-fill"></i>No hay registros</strong></h6>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination p-2">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>
    </main>

    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex flex-colum text-center alig-items-center">
                        <i class="bi bi-person-plus-fill"></i>
                        <h5 class="modal-title" id="exampleModalLabel">Crear Carrera</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-label">ID</div>
                            <input class="form-control" placeholder="carrera" id="input_carrera"></input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-label">Ingrese nombre de carrera</div>
                            <input class="form-control" placeholder="nombre" id="input_nombre"></input>
                        </div>

                        <div class="col">
                            <div class="form-label">Ingrese Especialidad</div>
                            <input class="form-control" placeholder="Especialidad" id="input_especialidad"></input>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-label">Seleccione la ubicacion</div>
                            <div class="input-group has-validation">

                                <select name="ubicacion" id="ubicaciones">
                                    <option value="0">---</option>
                                    <option value="1">Gomez Rendom - Instituto Guayaquil</option>
                                    <option value="2">CMI</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn buton-istg text-white text-center mb-2 w-100 " onclick="createUser()"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-floppy-fill"></i>
                        <spanan>Guardar Carrera</spanan>
                    </button>
                </div>


            </div>

        </div>
    </div>
@endsection
