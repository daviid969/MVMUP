    // JavaScript para manejar los formularios con AJAX
    document.addEventListener("DOMContentLoaded", function() {
        // Cambiar contraseña
        const changePasswordForm = document.getElementById('change-password-form');
        const passwordMessage = document.getElementById('password-message');
  
        if (changePasswordForm) {
          changePasswordForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
  
            const formData = new FormData(changePasswordForm);
  
            fetch('/configuracion/cambiar_contrasena.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text()) // Obtener la respuesta del servidor
            .then(data => {
              // Mostrar el mensaje de respuesta
              passwordMessage.innerHTML = `<div class="alert alert-success">${data}</div>`;
            })
            .catch(error => {
              // Mostrar un mensaje de error si algo falla
              passwordMessage.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
          });
        }
  
        // Cambiar correo
        const changeEmailForm = document.getElementById('change-email-form');
        const emailMessage = document.getElementById('email-message');
  
        if (changeEmailForm) {
          changeEmailForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
  
            const formData = new FormData(changeEmailForm);
  
            fetch('/configuracion/cambiar_correo.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text()) // Obtener la respuesta del servidor
            .then(data => {
              // Mostrar el mensaje de respuesta
              emailMessage.innerHTML = `<div class="alert alert-success">${data}</div>`;
            })
            .catch(error => {
              // Mostrar un mensaje de error si algo falla
              emailMessage.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
          });
        }
  
        // Cambiar nombre de usuario
        const changeUsernameForm = document.getElementById('change-username-form');
        const usernameMessage = document.getElementById('username-message');
  
        if (changeUsernameForm) {
          changeUsernameForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
  
            const formData = new FormData(changeUsernameForm);
  
            fetch('/configuracion/cambiar_username.php', {
              method: 'POST',
              body: formData
            })
            .then(response => response.text()) // Obtener la respuesta del servidor
            .then(data => {
              // Mostrar el mensaje de respuesta
              usernameMessage.innerHTML = `<div class="alert alert-success">${data}</div>`;
            })
            .catch(error => {
              // Mostrar un mensaje de error si algo falla
              usernameMessage.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
          });
        }
  
        // Cerrar sesión
        const logoutForm = document.getElementById('logout-form');
        const logoutMessage = document.getElementById('logout-message');
  
        if (logoutForm) {
          logoutForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío tradicional del formulario
  
            fetch('/configuracion/cerrar_sesion.php', {
              method: 'POST'
            })
            .then(response => response.text()) // Obtener la respuesta del servidor
            .then(data => {
              // Mostrar el mensaje de respuesta
              logoutMessage.innerHTML = `<div class="alert alert-success">${data}</div>`;
              // Redirigir al usuario después de cerrar sesión
              setTimeout(() => {
                window.location.href = '/index.html';
              }, 2000); // Redirigir después de 2 segundos
            })
            .catch(error => {
              // Mostrar un mensaje de error si algo falla
              logoutMessage.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
          });
        }
      });