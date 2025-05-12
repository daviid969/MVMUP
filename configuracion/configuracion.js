document.addEventListener('DOMContentLoaded', function() {
  function showPopup(message, isSuccess) {
    const popup = document.createElement('div');
    popup.className = `popup-message ${isSuccess ? 'success' : 'error'}`;
    popup.textContent = message;
    document.body.appendChild(popup);
    setTimeout(() => popup.remove(), 3000);
  }

  // Cambiar contraseña
  const changePasswordForm = document.getElementById('change-password-form');
  if (changePasswordForm) {
    changePasswordForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(changePasswordForm);
      fetch('/configuracion/cambiar_contrasena.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        showPopup(data, true);
      })
      .catch(error => {
        showPopup(`Error: ${error.message}`, false);
      });
    });
  }

  // Cambiar correo
  const changeEmailForm = document.getElementById('change-email-form');
  if (changeEmailForm) {
    changeEmailForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(changeEmailForm);
      fetch('/configuracion/cambiar_correo.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        showPopup(data, true);
      })
      .catch(error => {
        showPopup(`Error: ${error.message}`, false);
      });
    });
  }

  // Cambiar nombre de usuario
  const changeUsernameForm = document.getElementById('change-username-form');
  if (changeUsernameForm) {
    changeUsernameForm.addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(changeUsernameForm);
      fetch('/configuracion/cambiar_username.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        showPopup(data, true);
      })
      .catch(error => {
        showPopup(`Error: ${error.message}`, false);
      });
    });
  }

  // Cerrar sesión
  const logoutForm = document.getElementById('logout-form');
  if (logoutForm) {
    logoutForm.addEventListener('submit', function(event) {
      event.preventDefault();
      fetch('/configuracion/cerrar_sesion.php', {
        method: 'POST'
      })
      .then(response => response.text())
      .then(data => {
        showPopup(data, true);
        setTimeout(() => {
          window.location.href = '/index.html';
        }, 2000);
      })
      .catch(error => {
        showPopup(`Error: ${error.message}`, false);
      });
    });
  }
});