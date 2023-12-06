@extends('aside')

@section('titulo', 'Cursos')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-4">
            <!-- Título de la asignatura -->
            <div class="row">
                <div class="col-12">
                    <h1 class="text-white bg-primary p-2">Asignatura</h1>
                </div>
            </div>

            <!-- Tabla de asignaturas asignadas -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="width: 
                98%;">
                            <thead>
                                <tr>
                                    <th>Asignatura</th>
                                    <th>Horario</th>
                                    <th>Aula</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Asignaturas asignadas al maestro -->
                                <tr>
                                    <td>Ética Profesional</td>
                                    <td>Lunes 9:00 - 11:00</td>
                                    <td>Aula 102</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editarModal">Editar</button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#eliminarModal">Eliminar</button>
                                    </td>
                                </tr>
                                <!-- Puedes agregar más filas según sea necesario -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CRUD -->
            <div class="row mt-4">
                <div class="col-12">
                    <!-- Formulario CRUD aquí -->
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="asignatura">Asignatura</label>
                                <input type="text" class="form-control" id="asignatura"
                                    placeholder="Nombre de la asignatura">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="horario">Horario</label>
                                <input type="text" class="form-control" id="horario"
                                    placeholder="Horario de la asignatura">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="aula">Aula</label>
                                <input type="text" class="form-control" id="aula"
                                    placeholder="Aula de la asignatura">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modals de Edición y Eliminación -->
        <div class="modal" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal de edición -->
                        <form>
                            <div class="form-group">
                                <label for="editAsignatura">Nueva Asignatura</label>
                                <input type="text" class="form-control" id="editAsignatura"
                                    placeholder="Nombre de la asignatura">
                            </div>
                            <div class="form-group">
                                <label for="editHorario">Nuevo Horario</label>
                                <input type="text" class="form-control" id="editHorario"
                                    placeholder="Horario de la asignatura">
                            </div>
                            <div class="form-group">
                                <label for="editAula">Nueva Aula</label>
                                <input type="text" class="form-control" id="editAula"
                                    placeholder="Aula de la asignatura">
                            </div>
                            <button type="button" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Asignatura</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido del modal de eliminación -->
                        <p>¿Estás seguro de que deseas eliminar la asignatura seleccionada?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
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

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endsection
