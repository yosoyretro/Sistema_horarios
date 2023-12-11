@extends('aside')

@section('titulo', 'roles y permisos')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="card fondo-istg text-white d-flex aling-items-center justify-content-center">
        <h2 class="text-center">roles y permisos</h2>
    </div>
    <div class="card p-2 card-bg">
        <div class="container-fluid">
            <div class="row pt-4">
                <div class="col-3 input-group mb-3 ml-3">
                    <span class="input-group-text fondo-istg text-white" id="basic-addon1"><i class="bi bi-search text-negita"></i></span>
                    <input type="search" class="form-control" placeholder="Buscar Usuario">
                </div>
            </div>

            

        </div>

        <div class="row">
            <table class="container table-white table-bordered text-center">
                <thead>
                    <tr class="fondo-istg text-white">
                        <th class="p-2" scope="col">cedula</th>
                        <th class="p-2" scope="col">Nombres y apellidos</th>
                        <th class="p-2" scope="col">Usuario</th>
                        <th class="p-2" scope="col">Rol</th>
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
                        <td class="texto-pequeño">{{ $dato->created_at }}</td>
                        <td class="texto-pequeño">{{ $dato->updated_at }}</td>
                        <td class="p-2">
                            <button class="btn buton-istg text-white ">Editar permisos</button>
                            <button class="btn btn-danger text-white" >editar rol</button>
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



<script src="{{ asset('js/ServicioApis.js') }}"></script>


  
@endsection