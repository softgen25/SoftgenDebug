document.addEventListener ('DOMContentLoaded', function() {
    const form = document.getElementById('formularioReporte');
    const steps = document.querySelectorAll('.step');
    const progressBar = document.getElementById('progressBar');
    let currentStep = 0; // El índice del paso actual (0-indexed)

    // Función para actualizar la visibilidad de los pasos
    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
        const progress = ((stepIndex + 1) / steps.length) * 100;
        progressBar.style.width = progress + '%';
        progressBar.textContent = `Paso ${stepIndex + 1} de ${steps.length}`;
    }

    // Manejar clics en el botón "Siguiente"
    form.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', () => {
            // Validación para campos requeridos y su patrón en el paso actual
            let requiredInputs = steps[currentStep].querySelectorAll('[required]');
        
            let allFieldsValid = true;

            requiredInputs.forEach(input => {
                // Ahora usamos checkValidity() que revisa si el campo está vacío
                // o si no cumple con el 'pattern'
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                    allFieldsValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            // Si la validación falla, se muestra la alerta y se detiene la función
            if (!allFieldsValid) {
                alert('Por favor, completa todos los campos requeridos con el formato correcto antes de avanzar.');
                return; // Detiene la ejecución para no avanzar de paso
            }

            // Si la validación es exitosa y no es el último paso
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    // Manejar clics en el botón "Anterior"
    form.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });
    
    // Configura el manejador para el envío final del formulario
    form.addEventListener('submit', function (event) {
        // La lógica de validación del último paso se ejecutará aquí
        const lastStepInputs = steps[steps.length - 1].querySelectorAll('[required]');
        let lastStepValid = true;
        
        lastStepInputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('is-invalid');
                lastStepValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!lastStepValid) {
            alert('Por favor, completa todos los campos requeridos antes de finalizar el reporte.');
            event.preventDefault(); // Detiene el envío si el último paso no es válido
        }
    });

    showStep(currentStep);
});