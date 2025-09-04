// Espera a que todo el contenido de la página se cargue
document.addEventListener('DOMContentLoaded', function () {
    
    // 1. Conectar el botón a una función
    const addButton = document.getElementById('add-equipo-btn');
    addButton.addEventListener('click', agregarEquipo);

    // Variable para llevar la cuenta de los equipos
    let equipoIndex = 1;

    function agregarEquipo() {
        // El contenedor donde se añadirán los nuevos equipos
        const container = document.getElementById('equipos-container');
        
        // Crear un nuevo div para el formulario del equipo
        const nuevoEquipoDiv = document.createElement('div');
        nuevoEquipoDiv.className = 'equipo-group mb-3'; // Clases para el estilo

        let opcionesHTML = '<option value="">Seleccione un tipo de servicio</option>';
        if (tiposDeServicio && Array.isArray(tiposDeServicio)){
            tiposDeServicio.forEach(servicio => {
                opcionesHTML += `<option value="${servicio}">${servicio}</option>`;
                
            });
        } else {
            opcionesHTML += '<option value="" disable> No hay tipos de servicios disponibles</option>';
        }

        let pcionesHTML = '<option value="">Seleccione un tipo de informe</option>';
        // Se corrige la variable a 'tiposDeinforme' para que coincida con el archivo PHP
        if (tiposDeInforme && Array.isArray(tiposDeInforme)){
                tiposDeInforme.forEach(tinforme => {
                pcionesHTML += `<option value="${tinforme}">${tinforme}</option>`;
                
            });
        } else {
            pcionesHTML += '<option value="" disable> No hay tipos de servicios disponibles</option>';
        }
        
        // 2. HTML del nuevo formulario. Fíjate que los 'name' coinciden con el original
        // Usamos el 'equipoIndex' para que cada equipo sea único
        nuevoEquipoDiv.innerHTML = `
            <div class="row">
                <div class="col-md-3 md-3 mb-3">
                    <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
                    <select class="form-select" name="equipos[${equipoIndex}][ser_tipo_servicio]" id="tipo_servicio" required>
                        ${opcionesHTML}
                    </select>
                </div>
                <div class="col-md-3 md-3 mb-3">
                    <label for="tipo_informe" class="form-label">Tipo de informe</label>
                    <select class="form-select" name="tinforme[${equipoIndex}][ser_tipo_informe]" id="tipo_informe" required>
                        ${pcionesHTML}
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <h6>Nuevo Equipo</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarEquipo(this)">Eliminar</button>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label class="form-label">Tipo de Equipo</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][tipo_equipo]" placeholder="Mini split" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Marca</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][marca]" placeholder="LG" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Modelo</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][modelo]" placeholder="1004398" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label class="form-label">Serie</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][serie]" placeholder="AAA123" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Refrigerante</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][refrigerante]" placeholder="0l124R" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ubicación</label>
                    <input type="text" class="form-control" name="equipos[${equipoIndex}][ubicacion]" placeholder="Segundo piso" required>
                </div>
            </div>
            <hr class="mt-4">
        `;
        
        // 3. Añadir el nuevo formulario al contenedor
        container.appendChild(nuevoEquipoDiv);

        // --- INICIO DE CÓDIGO AÑADIDO PARA LA VALIDACIÓN EN TIEMPO REAL ---
        // Obtiene los nuevos campos de entrada dentro del div recién creado
        const tipoEquipoInput = nuevoEquipoDiv.querySelector('[name$="[tipo_equipo]"]');
        const marcaInput = nuevoEquipoDiv.querySelector('[name$="[marca]"]');

        // Función de validación en tiempo real para solo letras
        function soloLetras(event) {
            const input = event.target;
            // Elimina cualquier carácter que no sea una letra, un espacio o la ñ
            input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        }

        // Aplica la validación a los campos
        if (tipoEquipoInput) {
            tipoEquipoInput.addEventListener('input', soloLetras);
        }
        if (marcaInput) {
            marcaInput.addEventListener('input', soloLetras);
        }
        // --- FIN DE CÓDIGO AÑADIDO PARA LA VALIDACIÓN ---
        
        // Incrementar el índice para el próximo equipo
        equipoIndex++;
    }
});

// Función para eliminar el formulario de un equipo
function eliminarEquipo(button) {
    // El botón está dentro del div 'equipo-group', así que lo buscamos y lo eliminamos
    button.closest('.equipo-group').remove();
}