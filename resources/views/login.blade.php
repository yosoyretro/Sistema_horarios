<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/examples.css') }}">
    <link href="{{ asset('css/style-horarios.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('icons/cropped-logo.png') }}" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </link>

</head>

<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>Acceso</h1>
                                <p class="text-medium-emphasis">Iniciar sesión en su cuenta</p>

                                <!-- ($mensajes_temporales)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error : </strong>{{ $mensajes_temporales['msg'] }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                -->


                                <form method="POST" action="{{ route('login_controlador') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <span class="input-group-text fondo-istg">
                                            <i class="text-white fas fa-user"></i>
                                        </span>
                                        <input class="form-control font-lg" name="user" type="text" placeholder="Usuario" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text fondo-istg">
                                            <i class="text-white fas fa-key"></i>
                                        </span>
                                        <input class="form-control font-lg" name="password" type="password" placeholder="Contraseña" required>
                                    </div>
                                    <div class="mb-3">
                                        <select name="" aria-label="Default select example" class="font-lg text-center border-primary text-primary form-select " id="">
                                            <option selected hidden>Escoja el rol que desempeñas</option>
                                            <option>Administrador</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4 font-lg" type="submit">Ingresar</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a class="btn btn-link px-0 font-lg">Olvide mi contraseña</a>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="card col-md-5 text-white py-5 fondo-istg">
                            <div class="card-body text-center">
                                <div>
                                    <img class="img-icono-login" src="{{ asset('icons/pre-lg-istg.png') }}" height="125px">
                                    <br>
                                    <label class="texto-istg-2">Instituto Superir Tecnologico</label>
                                    <h1 class="h1">GUAYAQUIL</h1>
                                </div>
                                <div style="align-items: center;">
                                    <span>Author : Los semilleros</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>