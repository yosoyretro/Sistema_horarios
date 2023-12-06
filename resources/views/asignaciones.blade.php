@extends('aside')

@section('titulo', 'Asignaciones')
@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>
        <h2><img height="75px" src="{{ asset('icons/usuario.png') }}">Asignaciones</h2>
        <div class="card p-2 card-bg" style="border-radius: 12px;">
            <div class="container-fluid">
                <div class="row pt-4">
                    <div class="col-3 input-group mb-3 ml-3">
                        <span class="input-group-text fondo-istg text-white" id="basic-addon1"><i
                                class="bi bi-search text-negita"></i></span>
                        <input type="search" class="form-control" placeholder="Buscar Asignacion">
                    </div>
                </div>

                <div class="container">
                    <button class=" btn buton-istg text-white text-center mb-2" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="bi bi-person-plus-fill"></i>
                        <spanan>Nueva Asignacion</spanan>
                    </button>
                </div>

            </div>

            <div class="row">
                <table class="container table-white table-bordered text-center" style="width: 
                98%;">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="p-1" scope="col">Elegir</th>
                            <th class="p-1" scope="col">ID</th>
                            <th class="p-1" scope="col">Carrera</th>
                            <th class="p-1" scope="col">Asignatura</th>
                            <th class="p-1" scope="col">Horario</th>
                            <th class="p-1" scope="col">Docente</th>
                            <th class="p-1" scope="col">Fecha de creacion</th>
                            <th class="p-1" scope="col">Fecha de modificacion</th>
                            <th class="p-1" scope="col" colspan="4">Acciones</th>
                        </tr>
                        <tr>
                            <td>
                            <input type="checkbox" name="select" id="checkselect">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editarModal">Editar</button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#eliminarModal">Eliminar</button>
                            </td>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                    <tr>
                        <td colspan="9" rowspan="25" class="texto-pequeño text-danger">
                            <h6><strong><i class="bi bi-archive-fill"></i>No hay registros</strong></h6>
                        </td>
                    </tr>
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
                        <h5 class="modal-title" id="exampleModalLabel">Crear Asignacion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="row mb-2">
                        <div class="col">
                            <div class="form-label">Seleccione carrera</div>
                            <select class="form-select" aria-label="Default select example" id="selector_rol" require>
                                <option selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-label">Seleccione seleccione asignatura</div>
                            <select class="form-select" aria-label="Default select example" id="selector_rol" require>
                                <option selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-label">Seleccione horario</div>
                            <select class="form-select" aria-label="Default select example" id="selector_rol" require>
                                <option selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-label">Seleccione docente</div>
                            <select class="form-select" aria-label="Default select example" id="selector_rol" require>
                                <option selected>Seleccionar</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn buton-istg text-white text-center mb-2 w-100 " onclick="createUser()"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-floppy-fill"></i>
                        <spanan>Grabar Usuario</spanan>
                    </button>
                </div>


            </div>

        </div>
    </div>

    <script>
        const titulos = [];
        const setTitulo = (e) => {
            titulos.push(e);
        }
        const getTitulo = () => {
            return titulos;
        }
    </script>
    <script src="{{ asset('js/ServicioApis.js') }}"></script>
@endsection
