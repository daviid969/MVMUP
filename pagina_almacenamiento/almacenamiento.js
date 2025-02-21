document.addEventListener('DOMContentLoaded', function() {
    fetch('/pagina_almacenamiento/list_files.php')
        .then(response => response.json())
        .then(files => {
            const fileList = document.getElementById('fileList');
            files.forEach(file => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.innerHTML = `<a href="/pagina_almacenamiento/download.php?file=${encodeURIComponent(file)}">${file}</a>`;
                fileList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error:', error));
});