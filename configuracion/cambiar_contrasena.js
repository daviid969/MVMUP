document.addEventListener("DOMContentLoaded", function() {
    const changePasswordForm = document.getElementById('change-password-form');
    const passwordMessage = document.getElementById('password-message');

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
  });