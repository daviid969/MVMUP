document.addEventListener("DOMContentLoaded", function() {
  fetch('/check_session.php') 
    .then(response => response.json()) 
    .then(data => {
      if (data.loggedIn) {
        // Si el usuario ha iniciado sesion actualiza el navbar
        const authLink = document.getElementById('auth-link');
        authLink.innerHTML = '<a class="nav-link" href="/configuracion/index.html">Configuración</a>';

        // Mostrar el nombre del usuario en el footer
        document.getElementById('username').textContent = data.username;
      } else {
        // Si no ha iniciado sesion redirigir al login
        window.location.href = '/inicio_sesion/index.html';
      }
    })
    .catch(error => {
      console.error('Error al verificar la sesión:', error);
    });
});