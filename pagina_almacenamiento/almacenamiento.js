let currentPath = '';

document.addEventListener('DOMContentLoaded', function() {
    loadFiles();
});

function loadFiles(path = '') {
    currentPath = path;
    document.getElementById('uploadPath').value = currentPath; // Actualizar el path en el formulario de subida

    fetch(`/pagina_almacenamiento/list_files.php?path=${encodeURIComponent(path)}`)
        .then(response => response.json())
        .then(files => {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';

            // Botón para volver atrás
            if (path !== '') {
                const backItem = document.createElement('li');
                backItem.className = 'list-group-item';
                backItem.innerHTML = `
                    <button class="btn btn-link" onclick="loadFiles('${path.substring(0, path.lastIndexOf('/'))}')">
                        <i class="fas fa-arrow-left"></i> Volver
                    </button>
                `;
                fileList.appendChild(backItem);
            }

            files.forEach(file => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';

                const sharedBadge = file.shared ? '<span class="badge bg-info text-dark ms-2">Compartido</span>' : '';

                if (file.is_dir) {
                    listItem.innerHTML = `
                        <button class="btn btn-link" onclick="loadFiles('${file.path}')">
                            <i class="fas fa-folder"></i> ${file.name} ${sharedBadge}
                        </button>
                        <div class="btn-group">
                            ${!file.shared ? `
                                <button class="btn btn-primary btn-sm" onclick="shareItem('${file.path}', true)">
                                    <i class="fas fa-share"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteFile('${file.path}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                        </div>
                    `;
                } else {
                    listItem.innerHTML = `
                        ${file.name} ${sharedBadge}
                        <div class="btn-group">
                            <a href="/pagina_almacenamiento/download.php?file=${encodeURIComponent(file.path)}" class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            ${!file.shared ? `
                                <button class="btn btn-primary btn-sm" onclick="shareItem('${file.path}', false)">
                                    <i class="fas fa-share"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteFile('${file.path}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : ''}
                        </div>
                    `;
                }
                fileList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error:', error));
}
function shareFolder(folderPath) {
    const recipient = prompt('Introduce el email del destinatario:');
    if (!recipient) return;

    fetch('/pagina_almacenamiento/share_file.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ file: folderPath, recipient })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Carpeta compartida con éxito.');
    })
    .catch(error => console.error('Error:', error));
}
function deleteFile(filename) {
    
    if (confirm('¿Estás seguro de que quieres eliminar este archivo o carpeta? Todo su contenido será eliminado.')) {
        fetch('/pagina_almacenamiento/delete_file.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ file: filename })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadFiles(currentPath);
                alert('Archivo o carpeta eliminados con éxito.');
            } else {
                alert(data.error || 'Error al eliminar el archivo o carpeta.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
function createFolder() {
    const folderName = document.getElementById('folderName').value.trim();
    if (!folderName) {
        alert('Por favor, introduce un nombre para la carpeta.');
        return;
    }

    fetch('/pagina_almacenamiento/create_folder.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ folder: currentPath + '/' + folderName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadFiles(currentPath);
            alert('Carpeta creada con éxito');
            document.getElementById('folderName').value = ''; // Limpiar el campo
            const modal = bootstrap.Modal.getInstance(document.getElementById('createFolderModal'));
            modal.hide(); // Cerrar el modal
        } else {
            alert(data.error || 'Error al crear la carpeta');
        }
    })
    .catch(error => console.error('Error:', error));
}
function shareItem(itemPath, isFolder) {
    const recipient = prompt('Introduce el email del destinatario:');
    if (!recipient) return;

    fetch('/pagina_almacenamiento/share_file.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ file: itemPath, recipient, isFolder })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || 'Elemento compartido con éxito.');
    })
    .catch(error => console.error('Error:', error));
}