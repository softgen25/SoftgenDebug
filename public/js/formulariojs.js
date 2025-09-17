document.addEventListener('DOMContentLoaded', function() {
    console.log("El archivo formulariojs.js se ha cargado y ejecutado.");

    const steps = document.querySelectorAll('.step');
    const nextButtons = document.querySelectorAll('.next-btn');
    const prevButtons = document.querySelectorAll('.prev-btn');
    
    console.log("Pasos encontrados:", steps.length);
    console.log("Botones 'Siguiente' encontrados:", nextButtons.length);
    console.log("Botones 'Anterior' encontrados:", prevButtons.length);
    
    if (nextButtons.length === 0) {
        console.error("¡No se encontró ningún botón con la clase '.next-btn'! Revisa el HTML.");
    }

    let currentStep = 0;

    function updateStepDisplay() {
        steps.forEach(step => step.style.display = 'none');
        if (steps[currentStep]) {
            steps[currentStep].style.display = 'block';
        }
    }

    function validateCurrentStep() {
        const currentStepElement = steps[currentStep];
        const requiredFields = currentStepElement.querySelectorAll('[required]');
        let allValid = true;
        let invalidFields = [];

        requiredFields.forEach(field => {
            // Usa checkValidity() para validar campos vacíos y el patrón
            if (!field.checkValidity()) {
                allValid = false;
                field.classList.add('is-invalid');
                invalidFields.push(field);
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!allValid) {
            alert('Por favor, completa todos los campos obligatorios con el formato correcto.');
            // Opcional: enfoca el primer campo inválido
            if (invalidFields.length > 0) {
                invalidFields[0].focus();
            }
        }

        const inputsWithPattern = document.querySelectorAll('input[pattern]');

        inputsWithPattern.forEach(input => {
        // Añade un 'event listener' para el evento 'input'
        input.addEventListener('input', function() {
            // El 'pattern' se compila en una RegExp automáticamente
            const patternRegex = new RegExp(this.pattern);
            let sanitizedValue = '';

            // Itera sobre cada carácter en el valor del input
            for (let char of this.value) {
                // Si el carácter coincide con el patrón, lo añade al nuevo valor
                if (patternRegex.test(char)) {
                    sanitizedValue += char;
                }
            }
            // Actualiza el valor del input con los caracteres válidos
            this.value = sanitizedValue;
        });
    });

        return allValid;
    }

    // Un solo listener para los botones "Siguiente"
    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log("¡Clic en el botón 'Siguiente' detectado!");
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
            console.log(" ¡Clic en el botón 'Anterior' detectado!");
            if (currentStep > 0) {
                currentStep--;
                updateStepDisplay();
            }
        });
    });

    updateStepDisplay();
});