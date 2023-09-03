

function mensaje_eliminar(){
    Swal.fire({
        title: '¿Deseas eliminar este usuario?',
        text: 'Una ves que se borre este registro,no vas a poder recuperarlos',
        icon: 'question',
        showDenyButton: true,
        confirmButtonText: 'Cancelar',
        denyButtonText: `Eliminar`,
        }).then((result) => {
        let id = 2;
        axios.post(`http://127.0.0.1:8000/eliminarRegistro`).then((Response)=>{
            console.log("ELIMINO ?");
        });

        if (result.isDenied) {
            Swal.fire('Registro eliminado con exito', '', 'success')
        }
        
      })
}