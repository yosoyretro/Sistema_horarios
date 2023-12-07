@extends('aside')

@section('titulo', 'Inicio')

@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <!-- Small Box (Stat card) -->
        <h5 class="mb-2 mt-4"></h5>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>30</h3>

                <p>Horarios Registrados</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar"></i>
              </div>
              <a href="{{ asset('horarios') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>30<sup style="font-size: 20px"></sup></h3>

                <p>Calendarios</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="{{ asset('horarios') }}" class="small-box-footer">
                Crear <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="{{ asset('usuarios') }}" class="small-box-footer">
                Más info<i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>12</h3>

                <p>Versiones</p>
              </div>
              <div class="icon">
                <i class="fas fa-clock"></i>
              </div>
              <a href="#" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- =========================================================== -->
    </main>
@endsection
