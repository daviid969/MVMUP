document.getElementById('register-form').addEventListener('submit', function (e) {
    const formData = new FormData(this); 
    const messageDiv = document.getElementById('message'); 
    fetch('registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = `<div class="alert alert-success">Registro completado con éxito.</div>`;
        } else {
            messageDiv.innerHTML = `<div class="alert alert-danger">Error en el registro: ${data.message}</div>`;
        }
    })
    .catch(() => {
        messageDiv.innerHTML = `<div class="alert alert-danger">Error al procesar la solicitud. Por favor, inténtalo de nuevo más tarde.</div>`;
    });
});