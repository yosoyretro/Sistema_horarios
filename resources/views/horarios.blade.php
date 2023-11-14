@extends('aside')

@section('titulo', 'Horarios')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>
        <div class="col d-flex flex-column gap-2">

            <h4 class="fw-semibold mb-0 text-body-emphasis">Generar Horarios</h4>
            <p class="text-body-secondary">Puedes generar horarios de las clases semestrales</p>

            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCamposModal">Generar</a>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="agregarCamposModal" tabindex="-1" aria-labelledby="agregarCamposModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarCamposModalLabel">Campos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí puedes agregar los campos que desees -->
                    <label for="campo1">Materias:</label>
                    <input type="text" id="campo1" class="form-control mb-3">

                    <label for="campo2">Docente:</label>
                    <input type="text" id="campo2" class="form-control">

                    <label for="campo3">Horario:</label>
                    <input type="text" id="campo3" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarCamposBtn">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script> <!-- Asegúrate de incluir tus scripts correctamente -->
    <script>
        document.getElementById('guardarCamposBtn').addEventListener('click', function() {
            // Aquí puedes obtener los valores de los campos y realizar alguna acción
            var campo1 = document.getElementById('campo1').value;
            var campo2 = document.getElementById('campo2').value;

            // Realiza la lógica que necesites con los valores de los campos

            // Cierra el modal
            $('#agregarCamposModal').modal('hide');
        });
    </script>
@endsection
