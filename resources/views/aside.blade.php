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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     
</head>

<body>
    <header class="fondo-istg ">
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
            <li><a class="font-lg" href="#">
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
                                <li><a href="#modal" class="open-modal-link">
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
</body>

</html>