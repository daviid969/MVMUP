document.getElementById('register-form').addEventListener('submit', function (e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    const formData = new FormData(this); // Obtiene los datos del formulario
    const messageDiv = document.getElementById('message'); // Contenedor del mensaje

    fetch('registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
            messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(error => {
        messageDiv.innerHTML = `<div class="alert alert-danger">Error en la conexión con el servidor.</div>`;
    });
});