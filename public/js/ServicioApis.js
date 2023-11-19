url = "http://localhost:8000/api/v1/horario/";
const createUserApi = (obj) => {
    const headers = new Headers();
    headers.append('Content-Type', 'application/json');
    configuraciones = {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(obj)
    }

    fetch(url + "create_usuario/", configuraciones)
        .then((response) => response.json()).then(data => {
            console.log("Entrso aqui")
            console.log(data)
            if (data.ok) {
                mensajes(data.msg)
            } else {
                mensajes(data.msg_error, 'error');
            }
        })
        .catch(error => {
            //Se debe de usar en caso de que ocurra un error
            console.log("Soy el error");
            console.log(error);
        })
}

const showUsuario = () => {
    url_completa = url + "show_usuario/"
    fetch(url_completa)
        .then(response => response.json())
        .then(data => {
            console.log("Soy la data");
            if (!data.ok) throw new Error("Error interno en el servidor contactese con el administrador");
            return data
        })
        .catch(error => {
            return error
        });
}

const deleteUserApi = (obj) => {

    mensaje_confirmacion('¿Deseas eliminar este usuario?', 'question', 'Si aceptas no volveras a ver a este registro , al menos que te contastes con el administrador').then((result) => {
        if (result.isConfirmed) {
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');
            configuraciones = {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(obj)
            }
            console.log("ENTRO AQUI");
            url_completa = url + "delete_usuario/";
            fetch(url_completa, configuraciones)
                .then((response) => response.json())
                .then(data => {
                    console.log(data);
                    if (!data.ok) {
                        mensajes(data.msg_error, "error")
                    } else {
                        mensajes(data.msg)
                    }
                })
                .catch(error => {
                }

                )
        }
    })


}