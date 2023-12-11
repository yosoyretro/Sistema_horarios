const mensajes = (mensajes, tipo_mensaje = "succes") => {

    if (tipo_mensaje == "succes") {
        icono = "success"
        title = tipo_mensaje = "<h4 class='text-success'>Operacion realizada con exito</h4>";
    } else {
        icono = "error"
        title = "<h1 class='text-danger'>A  ocurrido un error</h1>";
    }

    Swal.fire({
        title: title,
        text: mensajes,
        icon: icono,
        confirmButtonText: "Aceptar",
    }).then((result) => {
        window.location.reload();
    });
}
const createParalelo = () => {
    try {
        console.log("estoy entrando en la funcion de create Paralelo")
        nemonico = document.getElementById("input_nemonico_paralelo").value;
        obj = {
            "nemonico": nemonico
        }
        createParaleloApi(obj)
    } catch (error) {
        console.log("Soy el error");
        console.log(error)
    }

}

const createNivel = () =>{
    let numero = document.getElementById('input_numero_nivel').value;
    let descripcion  = document.getElementById('input_descripcion_nivel').value;
    createNivelApi({numero:numero,descripcion:descripcion})
}
const createUser = () => {
    cedula = document.getElementById("input_cedula").value;
    nombres = document.getElementById("input_nombres").value;
    apellidos = document.getElementById("input_apellidos").value;
    usuario = document.getElementById("input_usuario").value;
    rol = document.getElementById("selector_rol").value;
    console.log("SOy el id del rol => " + rol);
    titulo = getTitulo();
    console.log(titulo);
    obj = {
        "cedula": cedula,
        "nombres": nombres + " " + apellidos,
        "usuario": usuario,
        "clave": cedula,
        "id_titulo_academico": titulo,
        "id_rol": rol
    };
    createUserApi(obj)

}

const mensaje_confirmacion = (title, icon, submensaje) => {
    return Swal.fire({
        title: title,
        icon: icon,//"question",
        text: submensaje,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Si deseo",
        denyButtonText: `No deseo`,
        confirmButtonColor: 'rgba(0, 0, 214, 0.782)',
        denyButtonColor: '#de2525'
    })
}
const elimnarUser = (id) => {
    deleteUserApi({ id_usuario: id })
    //mensaje_confirmacion('¿Deseas eliminar este usuario?','question','Si aceptas no volveras a ver a este registro , almenos que te contastes con el administrador ',mensajes())
}

const elimnarNivel = (id) => {
    deleteNivelApi({ id_nivel: id })
}

const elimnarParalelo = (id) => {
    deleteParaleloApi({ id_paralelo: id })
}

