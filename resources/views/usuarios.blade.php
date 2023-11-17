@extends('aside')

@section('titulo', 'Usuarios')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>
        <h4>Usuarios Registrados</h4>
        <div class="table-responsive small">
            <table class="table table-striped table-sm" style="border: black solid 0.5px">
                <thead>
                    <tr style="text-align: center">
                        <th scope="col">id</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Clave</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Fecha de creacion</th>
                        <th scope="col">Fecha de modificacion</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="text-align: center">
                        <td>1</td>
                        <td>Carlos Moreno</td>
                        <td>CarMoreno1</td>
                        <td>1234</td>
                        <td>Docente</td>
                        <td>Ingeniero</td>
                        <td>14/11/2023</td>
                        <td>Sin Modificar</td>
                        <td><button class="btn btn-primary rounded-pill px-1" type="button"data-bs-toggle="modal"
                                data-bs-target="#editarusuarios">Editar</button>
                            <button class="btn
                                btn-danger rounded-pill px-1"
                                type="button">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="editarusuarios" tabindex="-1" aria-labelledby="editarususarios" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarusuarios">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Aquí puedes agregar los campos que desees -->
                        <label for="campo1">Nombres:</label>
                        <br>
                        <input type="text" id="campo1" class="form-control" placeholder="Ingresar nombre">
                        <br>
                        <label for="campo2">Usuario:</label>
                        <input type="text" id="campo2" class="form-control" placeholder="Ingresar nombre de docente">
                        <br>
                        <label for="campo3">Clave:</label>
                        <input type="text" id="campo3" class="form-control" placeholder="Ingrese contraseña nueva">
                        <br>
                        <label for="opciones">Seleccionar Rol</label>
                        <br>
                        <select id="opciones" name="opciones">
                            <option value="opcion1">Docente</option>
                            <option value="opcion2">Administrador</option>
                            <!-- Agrega más opciones según sea necesario -->
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarCamposBtn">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
