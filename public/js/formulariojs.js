document.addEventListener('DOMContentLoaded', function() {
    // DETECTIVE 1: ¿Se está ejecutando este archivo?
    console.log("✅ El archivo formulariojs.js se ha cargado y ejecutado.");

    // Seleccionamos todos los elementos necesarios del DOM
    const steps = document.querySelectorAll('.step');
    const nextButtons = document.querySelectorAll('.next-btn');
    const prevButtons = document.querySelectorAll('.prev-btn');
    
    // DETECTIVE 2: ¿Encontramos los elementos HTML?
    console.log("Pasos encontrados:", steps.length);
    console.log("Botones 'Siguiente' encontrados:", nextButtons.length);
    console.log("Botones 'Anterior' encontrados:", prevButtons.length);
    
    if (nextButtons.length === 0) {
        console.error("🛑 ¡No se encontró ningún botón con la clase '.next-btn'! Revisa el HTML.");
    }

    let currentStep = 0;

    function updateStepDisplay() {
        steps.forEach(step => step.style.display = 'none');
        if (steps[currentStep]) {
            steps[currentStep].style.display = 'block';
        }
    }

    function validateCurrentStep() {
        // ... (la función de validación se queda igual)
        const currentStepElement = steps[currentStep];
        const requiredFields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
        let allValid = true;
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        if (!allValid) {
            alert('Por favor, completa todos los campos obligatorios.');
        }
        return allValid;
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            // DETECTIVE 3: ¿Se está registrando el clic?
            console.log("🖱️ ¡Clic en el botón 'Siguiente' detectado!");
            if (validateCurrentStep()) {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    updateStepDisplay();
                }
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log("🖱️ ¡Clic en el botón 'Anterior' detectado!");
            if (currentStep > 0) {
                currentStep--;
                updateStepDisplay();
            }
        });
    });

    updateStepDisplay();
});