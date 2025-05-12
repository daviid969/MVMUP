document.getElementById('register-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    function showPopup(message, isSuccess) {
        const popup = document.createElement('div');
        popup.className = `popup-message ${isSuccess ? 'success' : 'error'}`;
        popup.textContent = message;
        document.body.appendChild(popup);
        setTimeout(() => popup.remove(), 3000);
    }

    fetch('registro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showPopup(data.message, data.success);
    })
    .catch(error => {
        showPopup(`Error: ${error.message}`, false);
    });
});