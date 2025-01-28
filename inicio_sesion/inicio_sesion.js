document.getElementById('tutor').addEventListener('change', function() {
    const cursoTutorField = document.getElementById('curso-tutor');
    
    if (this.value === 'no-tutor') {
        cursoTutorField.style.display = 'none';
    } else {
        cursoTutorField.style.display = 'block';
    }
});
document.getElementById('add-curso').addEventListener('click', function() {
    const container = document.getElementById('cursos-ensenados-container');
    const newCurso = document.createElement('div');
    newCurso.classList.add('curso-ensenado');
    newCurso.innerHTML = `
        <label for="cursos-ensenados">Curso donde enseña:</label>
        <input type="text" name="cursos-ensenados">
        
        <label for="clases-ensenadas">Clases donde enseña (máximo 4):</label>
        <input type="text" name="clases-ensenadas">
        
        <label for="asignaturas">Asignaturas que enseña:</label>
        <input type="text" name="asignaturas">
    `;
    container.appendChild(newCurso);
});

// Mostrar u ocultar campos según el rol seleccionado
document.getElementById('role').addEventListener('change', function() {
    const alumnoFields = document.getElementById('alumno-fields');
    const profesorFields = document.getElementById('profesor-fields');
    
    if (this.value === 'alumno') {
        alumnoFields.style.display = 'block';
        profesorFields.style.display = 'none';
    } else {
        alumnoFields.style.display = 'none';
        profesorFields.style.display = 'block';
    }
});

// Cambiar entre inicio de sesión y registro
document.getElementById('switch-to-register').addEventListener('click', function() {
    document.getElementById('login-section').style.display = 'none';
    document.getElementById('register-section').style.display = 'block';
});

document.getElementById('switch-to-login').addEventListener('click', function() {
    document.getElementById('register-section').style.display = 'none';
    document.getElementById('login-section').style.display = 'block';
});