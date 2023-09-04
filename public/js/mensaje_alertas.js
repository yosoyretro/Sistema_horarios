const endpoint = "http://127.0.0.1:8000/api/eliminarRegistro/";
function mensaje_eliminar(id, op) {
    console.log(id);
    Swal.fire({
        title: '¿Deseas eliminar este usuario?',
        text: 'Una vez que se borre este registro, no vas a poder recuperarlo',
        icon: 'question',
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        denyButtonText: 'Eliminar',
        showDenyButton: true,
        showConfirmButton:false,
    }).then((result) => {
        if(result.isDenied){
            axios.post(`${endpoint}${id}/${op}`).then((Response) => {
                if (Response.data.ok) {
                    Swal.fire({
                        text: `${Response.data.data}`,
                        icon: 'success',
                        confirmButtonText: 'Recargar Pagina'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('Tuvimos un error al eliminar este usuario , Intente mas luego.')
                }
            });
        }
    })
}

