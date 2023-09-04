<!DOCTYPE html>
<html lang="es">

<head>
    <title>@yield('titulo')Inicio</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/asidebar-navbar/estilo1.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-horarios.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nombre+de+la+Fuente">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" rel="stylesheet">
    
</head>

<body>
    <header class="fondo-istg">
        <div class="navbar">
            <button class="toggle-button" id="toggle-button">
                <span class="material-icons">
                    menu
                </span>
                Menu
            </button>
            <li><a class="font-lg" href="#">
                    <span class="span-inicio material-icons">home</span>Inicio</a></li>
            <img src="{{ asset('icons/pre-lg-istg.png') }}" height="30px" style="width: 30px;">
            <li><a class="font-lg text-white">
                    <span class="span-inicio material-icons">
                        schedule
                    </span>Horarios</a></li>
            <div class="dropdown">
                <button class="Perfildropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="span-inicio material-icons">
                        account_circle
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                    <li><a class="font-lg dropdown-item" href="#">
                            <span class="span-inicio material-icons">
                                account_circle
                            </span>
                            Perfil</a></li>
                    <li><a class="font-lg dropdown-item" href="#">
                            <span class="span-inicio material-icons">
                                settings
                            </span>
                            Configuración</a></li>
                    <hr>
                    <li><a class="font-lg dropdown-item" href="#">
                            <span class="span-inicio material-icons">
                                exit_to_app
                            </span>
                            Cerrar Sesión</a></li>
                </div>
            </div>
        </div>
    </header>
    <div class="fondo-istg">
        <div class="sidebar" id="sidebar">
            
                <ul>
                    <li class="expandable">
                        <a href="#" class="font-lg">
                            <span class="material-icons">
                                add_circle
                            </span>
                            Añadir
                        </a>
                        <div class="submenu">
                            <ul>
                                <li><a href="{{ route('usuario') }}" class="open-modal-link">
                                        <span class="material-icons">
                                            people
                                        </span>
                                        Usuarios
                                    </a>
                                </li>
                                <li><a href="#">
                                        <span class="material-icons">
                                            school
                                        </span>
                                        Instituciones</a></li>
                                <li><a href="#">
                                        <span class="material-icons">
                                            book
                                        </span>
                                        Carreras
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="expandable">
                        <a href="#" class="font-lg">
                            <span class="material-icons">
                                tune
                            </span>
                            <label>Controlador</label>
                        </a>        
                    </li>
                </ul>

                
        </div>
        
    </div>
    <div class="content" id="content">
        @yield('contenido')
        <!-- Contenido principal aquí -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="{{ asset('js/mensaje_alertas.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    
</body>

</html>