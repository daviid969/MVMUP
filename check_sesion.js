document.addEventListener("DOMContentLoaded", function() {
    fetch('/check_session.php') // Llamar al archivo que verifica la sesión
      .then(response => response.json()) // Convertir la respuesta a JSON
      .then(data => {
        if (data.loggedIn) {
          // Si el usuario ha iniciado sesión, mostrar su nombre
          document.getElementById('username').textContent = data.username;
        } else if (data.redirect) {
          // Si no ha iniciado sesión, redirigir al login
          window.location.href = '/inicio_sesion/inicio_sesion.html';
        }
      })
      .catch(error => {
        console.error('Error al verificar la sesión:', error);
      });
  });