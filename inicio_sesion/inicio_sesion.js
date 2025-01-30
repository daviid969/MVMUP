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
        <label for="cursos-ensenados">Curso i clase donde enseña:</label>
                        <select name="cursos-ensenados">
                            <option value="1ESO">1ESO A</option>
                            <option value="1ESO">1ESO B</option>
                            <option value="1ESO">1ESO C</option>
    
                            <option value="2ESO">2ESO A</option>
                            <option value="2ESO">2ESO B</option>
                            <option value="2ESO">2ESO C</option>
                            
                            <option value="3ESO">3ESO A</option>
                            <option value="3ESO">3ESO B</option>
                            <option value="3ESO">3ESO C</option>
                            <option value="3ESO">3ESO D</option>
    
                            <option value="4ESO">4ESO A</option>
                            <option value="4ESO">4ESO B</option>
                            <option value="4ESO">4ESO C</option>
                            <option value="4ESO">4ESO D</option>
    
                            <option value="BATXILLERATO_CIENCIAS_TECNOLOGIA">BATXILLERATO DE CIENCIAS I TECNOLOGIA 1r</option>
                            <option value="BATXILLERATO_CIENCIAS_TECNOLOGIA">BATXILLERATO DE CIENCIAS I TECNOLOGIA 2n</option>
    
                            <option value="BATXILLERATO_HUMANIDAD_CIENCIAS_SOCIALES">BATXILLERATO DE HUMANIDAD I CIENCIAS SOCIALES 1r</option>
                            <option value="BATXILLERATO_HUMANIDAD_CIENCIAS_SOCIALES">BATXILLERATO DE HUMANIDAD I CIENCIAS SOCIALES 2n</option>
    
                            <option value="DAW">DAW 1r</option>
                            <option value="DAW">DAW 2n</option>
    
                            <option value="ASIX">ASIX 1r</option>
                            <option value="ASIX">ASIX 2n</option>
    
                            <option value="SMIX">SMIX 1r</option>
                            <option value="SMIX">SMIX 2n</option>
                        </select>
    
        
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
        alumnoFields.style.display = 'flex';
        profesorFields.style.display = 'none';
    } if (this.value === 'profesor'){
        alumnoFields.style.display = 'none';
        profesorFields.style.display = 'flex';
    }
});

// Cambiar entre inicio de sesión y registro
document.getElementById('switch-to-register').addEventListener('click', function() {
    document.getElementById('login-section').style.display = 'none'; //El formulario login desepareze cambiado su valor de display a none
    document.getElementById('register-section').style.display = 'block'; //El formulario de registro apareze cambiado su valor de display al que estoy usando
    document.body.style.marginTop = '11rem';
    document.body.style.marginBottom = '10rem';
});
//Lo mismo pero viceversa
document.getElementById('switch-to-login').addEventListener('click', function() {
    document.getElementById('register-section').style.display = 'none';
    document.getElementById('login-section').style.display = 'block';
    document.body.style.marginTop = '0rem';
    document.body.style.marginBottom = '0rem';
});