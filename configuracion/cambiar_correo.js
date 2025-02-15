document.addEventListener("DOMContentLoaded", function() {
const changeEmailForm = document.getElementById('change-email-form');
const emailMessage = document.getElementById('email-message');

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
});
