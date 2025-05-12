document.addEventListener("DOMContentLoaded", function() {
  function showPopup(message, isSuccess) {
    const popup = document.createElement('div');
    popup.className = `popup-message ${isSuccess ? 'success' : 'error'}`;
    popup.textContent = message;
    document.body.appendChild(popup);
    setTimeout(() => popup.remove(), 3000);
  }

  fetch('/check_session.php') 
    .then(response => response.json()) 
    .then(data => {
      if (data.loggedIn) {
        showPopup(`Bienvenido, ${data.username}`, true);
      } else {
        showPopup('Redirigiendo al inicio de sesión...', false);
        setTimeout(() => {
          window.location.href = '/inicio_sesion/index.html';
        }, 2000);
      }
    })
    .catch(error => {
      showPopup('Error al verificar la sesión: ' + error.message, false);
    });
});