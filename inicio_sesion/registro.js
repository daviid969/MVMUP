document.getElementById('register-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

    // Obtener los datos del formulario
    const formData = {
        username: document.getElementById('new-username').value,
        nombre: document.getElementById('name').value,
        apellidos: document.getElementById('surname').value,
        email: document.getElementById('alumno-email').value,
        curso: document.querySelector('select[name="curso"]').value,
        password: 'contraseña_segura' // Aquí deberías obtener la contraseña de un campo de contraseña
    };

    // Enviar los datos al servidor
    fetch('/ruta/al/script/php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registro exitoso');
            window.location.href = '/inicio_sesion/inicio_sesion.html'; // Redirigir al inicio de sesión
        } else {
            alert('Error en el registro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});