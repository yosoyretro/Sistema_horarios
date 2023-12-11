@extends('aside')

@section('titulo', 'Cursos y paralelo')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <br>
    <div class="card fondo-istg text-white d-flex aling-items-center justify-content-center">
        <h2 class="text-center">Cursos y paralelos</h2>
    </div>
    <div class="card p-2 card-bg">

        <div class="row">
            <div class="col">
                <div class="card fondo-istg text-white d-flex aling-items-center justify-content-center">
                    <h2 class="text-center">Registros de Cursos</h2>
                </div>
                <button class=" btn buton-istg text-white text-center mb-2" data-bs-toggle="modal" data-bs-target="#modal_curso">
                    <i class="bi bi-person-plus-fill"></i>
                    <spanan>Registrar nuevo Curso</spanan>
                </button>
                <table class="container table-white table-bordered text-center">
                    <thead>
                        <tr class="fondo-istg text-white">
                            <th class="p-2" scope="col">Numero</th>
                            <th class="p-2" scope="col">Descripcion</th>
                            <th class="p-2" scope="col">Fecha de creacion</th>
                            <th class="p-2" scope="col">Fecha de modificacion</th>
                            <th class="p-2" scope="col" colspan="4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @if (count($data_nivel) >= 1)
                        @foreach ($data_nivel as $dato)
                        <tr>
                            <td class="texto-pequeño">{{ $dato->numero }}</td>
                            <td class="texto-pequeño">{{ $dato->descripcion }}</td>
                            <td class="texto-pequeño">{{ $dato->created_at }}</td>
                            <td class="texto-pequeño">{{ $dato->updated_at }}</td>
                            <td class="p-2">
                                <!-- <button class="btn buton-istg text-white ">Editar</button> -->
                                <button class="btn btn-danger text-white" onclick="elimnarNivel( {{ $dato->id_nivel }} )">Eliminar</button>

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
            </div>

            <div class="col">
                <div class="card fondo-istg text-white d-flex aling-items-center justify-content-center">
                    <h2 class="text-center">Registros de Paralelos</h2>
                </div>
                <button class=" btn buton-istg text-white text-center mb-2" data-bs-toggle="modal" data-bs-target="#modal_paralelo">
                    <i class="bi bi-person-plus-fill"></i>
                    <spanan>Registrar nuevo paralelo</spanan>
                </button>

                <table class="container table-white table-bordered text-center">
                    <thead>
                        <tr class="fondo-istg text-white">
                            <th class="p-2" scope="col">Nombre</th>
                            <th class="p-2" scope="col">Fecha de creacion</th>
                            <th class="p-2" scope="col">Fecha de modificacion</th>
                            <th class="p-2" scope="col" colspan="4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">

                        @if (count($data_paralelo) >= 1)
                        @foreach ($data_paralelo as $key => $dato)
                        <tr>
                            <td class="texto-pequeño">{{ $dato->paralelo }}</td>
                            <td class="texto-pequeño">{{ $dato->created_at }}</td>
                            <td class="texto-pequeño">{{ $dato->updated_at }}</td>
                            <td class="p-2">
                                <button class="btn btn-danger text-white" onclick="elimnarParalelo( {{ $dato->id_paralelo }} )">Eliminar</button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" rowspan="25" class="texto-pequeño text-danger">
                                <h6><strong><i class="bi bi-archive-fill"></i>No hay registros </strong></h6>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

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

<!--MODAL PARALELO-->
<div class="modal" id="modal_paralelo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex flex-colum text-center alig-items-center">
                    <i class="bi bi-person-plus-fill"></i>
                    <h5 class="modal-title" id="exampleModalLabel">Crear Paralelo</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-label">Ingrese el nemonico del paralelo</div>
                        <input class="form-control" placeholder="Ingrese el paralelo" id="input_nemonico_paralelo"></input>
                    </div>
                </div>
                <br>
                <button class="btn buton-istg text-white text-center mb-2 w-100 " onclick="createParalelo()" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-floppy-fill"></i>
                    <spanan>Grabar Paralelo</spanan>
                </button>
            </div>


        </div>
    </div>
</div>


<!--MODAL CURSO-->
<div class="modal" id="modal_curso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex flex-colum text-center alig-items-center">
                    <i class="bi bi-person-plus-fill"></i>
                    <h5 class="modal-title" id="exampleModalLabel">Crear curso</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-label">Ingrese el numero del nivel</div>
                        <input class="form-control" placeholder="Ingrese el numero del nivel" id="input_numero_nivel"></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-label">Ingrese la descripcion del nivel</div>
                        <input class="form-control" placeholder="Ingrese la descripcion del nivel" id="input_descripcion_nivel"></input>
                    </div>
                </div>

                <br>
                <button class="btn buton-istg text-white text-center mb-2 w-100" onclick="createNivel()" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-floppy-fill"></i>
                    <spanan>Grabar Nivel</spanan>
                </button>
            </div>


        </div>
    </div>
</div>

<script src="{{ asset('js/ServicioApis.js') }}"></script>
@endsection