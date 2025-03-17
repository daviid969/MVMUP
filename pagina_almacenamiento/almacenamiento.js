document.addEventListener('DOMContentLoaded', function() {
    loadFiles();
});

function loadFiles() {
    fetch('/pagina_almacenamiento/list_files.php')
        .then(response => response.json())
        .then(files => {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = ''; 
            files.forEach(file => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
                    ${file}
                    <div class="btn-group">
                        <a href="/pagina_almacenamiento/download.php?file=${encodeURIComponent(file)}" class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteFile('${file}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-info btn-sm" onclick="shareFile('${file}')">
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                `;
                fileList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error:', error));
}

function createFolder() {
    const folderName = document.getElementById('folderName').value;
    fetch('/pagina_almacenamiento/create_folder.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({folder: folderName})
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            loadFiles(); 
            alert('Carpeta creada con éxito');
        } else {
            alert(data.error || 'Error al crear la carpeta');
        }
    });
}

function deleteFile(filename) {
    if(confirm('¿Estás seguro de que quieres eliminar este archivo?')) {
        fetch('/pagina_almacenamiento/delete_file.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({file: filename})
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                loadFiles(); 
                alert('Archivo eliminado con éxito');
            } else {
                alert(data.error || 'Error al eliminar el archivo');
            }
        });
    }
}

let currentFileToShare = '';

function shareFile(filename) {
    currentFileToShare = filename;
    new bootstrap.Modal(document.getElementById('shareModal')).show();
}

function confirmShare() {
    const email = document.getElementById('recipientEmail').value;
    fetch('/pagina_almacenamiento/share_file.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            file: currentFileToShare,
            recipient: email
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        new bootstrap.Modal(document.getElementById('shareModal')).hide();
    });
}
