let cursoCount = 0;

document.getElementById('add-curso').addEventListener('click', function() {
    addCurso();
});

function addCurso() {
    cursoCount++;
    const container = document.getElementById('cursos-ensenados-container');
    const newCurso = document.createElement('div');
    newCurso.classList.add('curso-ensenado', 'mb-3');
    newCurso.innerHTML = `
        <label for="cursos-ensenados-${cursoCount}" class="form-label">Curso y clase donde enseña:</label>
        <select name="cursos-ensenados-${cursoCount}" class="form-select mb-3">
            <option value="1ESO-A">1ESO A</option>
            <option value="1ESO-B">1ESO B</option>
            <option value="1ESO-C">1ESO C</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="2ESO-A">2ESO A</option>
            <option value="2ESO-B">2ESO B</option>
            <option value="2ESO-C">2ESO C</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="3ESO-A">3ESO A</option>
            <option value="3ESO-B">3ESO B</option>
            <option value="3ESO-C">3ESO C</option>
            <option value="3ESO-D">3ESO D</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="4ESO-A">4ESO A</option>
            <option value="4ESO-B">4ESO B</option>
            <option value="4ESO-C">4ESO C</option>
            <option value="4ESO-D">4ESO D</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="BATXILLERATO_CIENCIAS_TECNOLOGIA-1">BATX. CIENCIAS/T. 1r</option>
            <option value="BATXILLERATO_CIENCIAS_TECNOLOGIA-2">BATX. CIENCIAS/T. 2n</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="BATXILLERATO_HUMANIDAD_CIENCIAS_SOCIALES-1">BATX. HUMANIDAD/CS 1r</option>
            <option value="BATXILLERATO_HUMANIDAD_CIENCIAS_SOCIALES-2">BATX. HUMANIDAD/CS 2n</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="DAW-1">DAW 1r</option>
            <option value="DAW-2">DAW 2n</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="ASIX-1">ASIX 1r</option>
            <option value="ASIX-2">ASIX 2n</option>
            <option disabled>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</option>
            <option value="SMIX-1">SMIX 1r</option>
            <option value="SMIX-2">SMIX 2n</option>
            <option value="SMIX-2">SMIX 2n</option>   
        </select>

        <label for="asignaturas-${cursoCount}" class="form-label">Asignaturas que enseña:</label>
        <input type="text" name="asignaturas-${cursoCount}" class="form-control mb-3">

        <button type="button" class="btn btn-danger remove-curso">Eliminar curso</button>
    `;
    container.appendChild(newCurso);

    // Añadir evento para eliminar curso
    newCurso.querySelector('.remove-curso').addEventListener('click', function() {
        removeCurso(newCurso);
    });
}

function removeCurso(cursoElement) {
        cursoElement.remove();
        cursoCount--;
    }


// Mostrar u ocultar campos según el rol seleccionado
document.getElementById('role').addEventListener('change', function() {
    const alumnoFields = document.getElementById('alumno-fields');
    const profesorFields = document.getElementById('profesor-fields');
    
    if (this.value === 'alumno') {
        alumnoFields.style.display = 'block';
        profesorFields.style.display = 'none';
    } else if (this.value === 'profesor') {
        alumnoFields.style.display = 'none';
        profesorFields.style.display = 'block';
    }
});
