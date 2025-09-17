document.addEventListener('DOMContentLoaded', function () {
    const canvasTecnico = document.getElementById('firma-tecnico-canvas');
    const canvasCliente = document.getElementById('firma-cliente-canvas');

    if (canvasTecnico && canvasCliente) {
        const signaturePadTecnico = new SignaturePad(canvasTecnico, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        const signaturePadCliente = new SignaturePad(canvasCliente, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            [canvasTecnico, canvasCliente].forEach(canvas => {
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            });
            signaturePadTecnico.clear();
            signaturePadCliente.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        const btnLimpiarTecnico = document.getElementById('limpiar-tecnico');
        if (btnLimpiarTecnico) {
            btnLimpiarTecnico.addEventListener('click', () => signaturePadTecnico.clear());
        }

        const btnLimpiarCliente = document.getElementById('limpiar-cliente');
        if (btnLimpiarCliente) {
            btnLimpiarCliente.addEventListener('click', () => signaturePadCliente.clear());
        }

        const form = document.getElementById('form-informe-completo');
        if (form) {
            form.addEventListener('submit', function (event) {
                if (signaturePadTecnico.isEmpty() || signaturePadCliente.isEmpty()) {
                    alert("Ambas firmas son requeridas para guardar el informe.");
                    event.preventDefault();
                    return;
                }

                const inputTecnico = document.getElementById('firma-tecnico-data');
                const inputCliente = document.getElementById('firma-cliente-data');

                if (inputTecnico && inputCliente) {
                    inputTecnico.value = signaturePadTecnico.toDataURL('image/png');
                    inputCliente.value = signaturePadCliente.toDataURL('image/png');
                }
            });
        }
    }
});
