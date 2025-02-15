document.getElementById('register-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = {
        username: document.getElementById('new-username').value,
        nombre: document.getElementById('name').value,
        apellidos: document.getElementById('surname').value,
        email: document.getElementById('alumno-email').value,
        curso: document.querySelector('select[name="curso"]').value,
        password: 'contraseña_segura' // Aquí deberías obtener la contraseña de un campo de contraseña
    };

    console.log('Datos del formulario:', formData); // Verifica los datos en la consola del navegador

    fetch('/ruta/al/script/php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data); // Verifica la respuesta del servidor
        if (data.success) {
            alert('Registro exitoso');
            window.location.href = '/inicio_sesion/inicio_sesion.html';
        } else {
            alert('Error en el registro: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});