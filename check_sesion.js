document.addEventListener("DOMContentLoaded", function() {
  fetch('/check_session.php') // Llamar al archivo que verifica la sesión
    .then(response => response.json()) // Convertir la respuesta a JSON
    .then(data => {
      if (data.loggedIn) {
        // Si el usuario ha iniciado sesión, actualizar el navbar
        const authLink = document.getElementById('auth-link');
        authLink.innerHTML = '<a class="nav-link" href="/configuracion/configuracion.html">Configuración</a>';

        // Mostrar el nombre del usuario en el footer
        document.getElementById('username').textContent = data.username;
      } else {
        // Si no ha iniciado sesión, redirigir al login
        window.location.href = '/inicio_sesion/inicio_sesion.html';
      }
    })
    .catch(error => {
      console.error('Error al verificar la sesión:', error);
    });
});