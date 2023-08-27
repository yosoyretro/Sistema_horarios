/*!
* Start Bootstrap - Simple Sidebar v6.0.6 (https://startbootstrap.com/template/simple-sidebar)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
*/
// 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function eliminarAlerta(button) {
    // Accede al elemento padre (la div con clase "alert") y lo elimina
    var alertContainer = button.parentNode;
    alertContainer.remove();
  }

  
  // Obtenemos el botón por su ID
  var addbto = document.getElementById('addbto');

  // Agregamos un evento de clic al botón
addbto.addEventListener('click', function() {
    // Obtenemos el modal por su ID
    var myModal = document.getElementById('myModal');
    
    // Mostramos el modal utilizando el método 'modal' de Bootstrap
    // 'show' es el parámetro que indica que queremos mostrar el modal
    var modal = new bootstrap.Modal(myModal);
    modal.show();
  });