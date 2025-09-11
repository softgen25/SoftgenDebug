<?php
// Se recomienda descomentar esta sección para producción

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /softGenn/public/index.php?action=login');
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reporte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    
    <link href="https://fonts.googleapis.com/css2?family=Saira:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    


    <link rel="stylesheet" href="../public/css/estiloequipo.css">
    
    <link rel="stylesheet" href="../public/css/cssBoostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/jsBoostrap/bootstrap.min.js">

    <link rel="icon" type="image/png" sizes="16x16" href="../public/img/Logo Favicon 16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/img/Logo favicon 1.0.png">
    <link rel="icon" type="image/png" sizes="180x180" href="../public/img/Logo Favicon 180x180.png">
        
    
    <style>
        .step { display: none; }
        .step.active { display: block; }
        body {font-family: 'Saira'}
    </style>
</head>
<body  style="background-color: #ececec;">
    
<header>
    <div class="bg-primary">
        <?php
            // CORRECCIÓN: Rutas de inclusión robustas usando __DIR__
            include __DIR__ . '/../../../public/headerandfoother/header1.php';
        ?>
    </div>
</header>

<div class="container mt-5 mb-5 shadow p-4 rounded"  style="background-color: #ffffffff;">
    <!-- 
        CORRECCIÓN 1: La acción apunta a 'guardar_informe' y se añade 'enctype' para la subida de archivos.
    -->
    <form id="formularioReporte" action="?action=guardar_informe" method="post" enctype="multipart/form-data" class="form-container">
        <h2 class="mb-4 text-center">Crear Reporte de Servicio</h2>
        <div class="progress mb-4" style="height: 25px;">
            <div id="progressBar" class="progress-bar" style="background-color: #135787;" role="progressbar" style="width: 20%;">Paso 1 de 5</div>
        </div>

        <!-- PASO 1: DATOS DEL CLIENTE Y UBICACIÓN -->
        <div class="step active" id="step1">
            <h5 class="mb-3">1. Datos del Cliente y Ubicación</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="selectCliente" class="form-label">Cliente</label>
                    <!-- CORRECCIÓN: El name es 'id_cliente' para coincidir con el modelo -->
                    <select class="form-select" name="id_cliente" id="selectCliente" required>
                        <option value="">Seleccione un cliente</option>
                        <?php if (!empty($clientes)): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= htmlspecialchars($cliente['id_cliente']) ?>">
                                    <?= htmlspecialchars($cliente['razon_social']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay clientes disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="selectEmpresa" class="form-label">Empresa</label>
                    <!-- CORRECCIÓN: El name es 'id_empresa' -->
                    <select class="form-select" name="id_empresa" id="selectEmpresa" required>
                        <option value="">Seleccione una empresa</option>
                        <?php if (!empty($empresas)):?>
                            <?php foreach ($empresas as $empresa):?>
                                <option value="<?= htmlspecialchars($empresa['id_empresa'])?>">
                                    <?= htmlspecialchars($empresa['razon_social'])?>
                                </option>
                            <?php endforeach;?>
                        <?php else: ?>
                            <option value="" disabled>No hay empresas disponibles</option>
                        <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sitio" class="form-label">Sitio</label>
                    <input type="text" class="form-control" id="sitio" name="ubi_sitio" placeholder="Ej: Oficina Principal, Bodega" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ubi_ciudad" placeholder="Ej: Bucaramanga" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="departamento" class="form-label">Departamento</label>
                    <select class="form-select" name="ubi_departamento" id="departamento" required>
                        <option value="">Seleccione un departamento</option>
                        <?php if (!empty($departamentos)): ?>
                            <?php foreach ($departamentos as $depto): ?>
                                <option value="<?= htmlspecialchars($depto); ?>">
                                    <?= htmlspecialchars($depto); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="barrio" class="form-label">Barrio</label>
                    <input type="text" class="form-control" id="barrio" name="ubi_barrio" placeholder="Ej: Cabecera" required>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="localidad" class="form-label">Localidad</label>
                    <input type="text" class="form-control" id="localidad" name="ubi_localidad" placeholder="Ej: Piedecuesta" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="calle" class="form-label">Dirección (Calle, Carrera, Número)</label>
                    <input type="text" class="form-control" id="calle" name="ubi_calle" placeholder="Ej: Cra 33 # 48-10" required>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn next-btn" style="background-color:#135787; color: #ffffff">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>

        <!-- PASO 2: DATOS DEL EQUIPO Y SERVICIO -->
        <div class="step" id="step2">
            <h5 class="mb-3">2. Datos del Servicio y Equipo(s)</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
                    <select class="form-select" name="ser_tipo_servicio" id="tipo_servicio" required>
                        <option value="">Seleccione un tipo de servicio</option>
                        <?php if (!empty($tipos_servicio)): ?>
                            <?php foreach ($tipos_servicio as $servicio):?>
                                <option value="<?= htmlspecialchars($servicio); ?>">
                                    <?= htmlspecialchars($servicio); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay tipos de servicio</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo_informe" class="form-label">Tipo informe</label>
                    <select class="form-select" name="ser_tipo_informe" id="tipo_informe" required>
                        <option value="">Seleccione el tipo de informe</option>
                        <?php if (!empty($tipos_informe)): ?>
                            <?php foreach ($tipos_informe as $tinforme):?>
                                <option value="<?=htmlspecialchars($tinforme); ?>">
                                    <?=htmlspecialchars($tinforme); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No hay tipos de informes</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <hr>
            <div id="equipos-container">
                <div class="equipo-group mb-3">
                    <h6>Equipo 1</h6>
                    <div class="row">
                        <!-- CORRECCIÓN: Nombres de campos de equipo con prefijo 'equi_' -->
                        <div class="col-md-4"><label class="form-label">Tipo de Equipo</label><input type="text" class="form-control" name="equipos[0][equi_tipo_equipo]" placeholder="Mini split" required></div>
                        <div class="col-md-4"><label class="form-label">Marca</label><input type="text" class="form-control" name="equipos[0][equi_marca]" placeholder="Lg" required></div>
                        <div class="col-md-4"><label class="form-label">Modelo</label><input type="text" class="form-control" name="equipos[0][equi_modelo]" placeholder="1004398" required></div>  
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4"><label class="form-label">Serie</label><input type="text" class="form-control" name="equipos[0][equi_serie]" placeholder="AAA123" required></div>
                        <div class="col-md-4"><label class="form-label">Refrigerante</label><input type="text" class="form-control" name="equipos[0][equi_refrigerante]" placeholder="R-410A" required></div>
                        <div class="col-md-4"><label class="form-label">Ubicación del Equipo</label><input type="text" class="form-control" name="equipos[0][equi_ubicacion]" placeholder="Segundo piso, oficina 1" required></div>
                    </div>
                    <hr class="mt-4">
                </div>   
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <button type="button" id="add-equipo-btn" class="btn btn-outline-dark">
                        <i class="bi bi-plus-circle me-2"></i>Añadir Otro Equipo
                    </button>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#135787; color: #ffffff"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="button" class="btn next-btn" style="background-color:#135787; color: #ffffff">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>

        <!-- PASO 3: INSPECCIÓN GENERAL -->
        <div class="step" id="step3">
            <h5 class="mb-3">3. Detalles de Inspección General (Checklist)</h5>
            <div class="row">
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_goteos"  value="1" ><label class="form-check-label ms-2">Goteras</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_gabinete" value="1"> <label class="form-check-label ms-2">Gabinete</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_filtro" value="1"> <label class="form-check-label ms-2">Filtro</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_drenaje" value="1"> <label class="form-check-label ms-2">Drenaje</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_serpentin" value="1"> <label class="form-check-label ms-2">Serpentin</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_refrigerante" value="1"> <label class="form-check-label ms-2">Fuga de Refrigerante</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_vibracion" value="1"> <label class="form-check-label ms-2">Vibración Anormal</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_tablero_electrico" value="1"> <label class="form-check-label ms-2">Tablero Electrico</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_aislamiento_gabinete" value="1"> <label class="form-check-label ms-2">Aislamiento</label></div>
                <div class="col-md-4 col-6 mb-2"><input type="checkbox" class="form-check-input" name="ig_flujo_aire" value="1"> <label class="form-check-label ms-2">Flujo de Aire</label></div>
            </div>
            <hr>
            <h5 class="mb-3 mt-3">Datos Eléctricos y de Temperatura</h5>
            <div class="row">
                <div class="col-md-3 mb-3"><label class="form-label">Amperios</label><input type="number" step="0.01" class="form-control" name="ig_amperios" placeholder="Ej: 5.25" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Voltaje</label><input type="number" step="0.01" class="form-control" name="ig_voltaje" placeholder="Ej: 220" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Temp. Suministro (°C)</label><input type="number" step="0.01" class="form-control" name="ig_temp_suministro" placeholder="Ej: 18.5" required></div>
                <div class="col-md-3 mb-3"><label class="form-label">Temp. Retorno (°C)</label><input type="number" step="0.01" class="form-control" name="ig_temp_retorno" placeholder="Ej: 25.0" required></div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#135787; color: #ffffff"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="button" class="btn next-btn" style="background-color:#135787; color: #ffffff">Siguiente <i class="bi bi-caret-right-fill"></i></button>
            </div>
        </div>
    
        <!-- PASO 4: REVISIÓN MECÁNICA Y HORARIOS -->
        <div class="step" id="step4"> 
            <h5 class="mb-3">4. Revisión Mecánica y Horarios</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="Ejes" class="form-label">Estado de ejes</label>
                    <select name="rm_ejes" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Rodamientos"class="form-label">Rodamientos</label>
                    <select name="rm_rodamientos" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Chumaceras" class="form-label">Chumaceras</label>
                    <select name="rm_chumaceras" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Poleas" class="form-label">Poleas</label>
                    <select name="rm_poleas" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="Correas" class="form-label">Correa</label>
                    <select name="rm_correas" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Rejillas" class="form-label">Rejillas</label>
                    <select name="rm_rejillas" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Pintura" class="form-label">Pintura</label>
                    <select name="rm_pintura" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="Ductos" class="form-label">Ductos</label>
                    <select name="rm_ductos" class="form-select" required><option value="1">Bueno</option><option value="2">Regular</option><option value="3">Malo</option><option value="4">Requiere cambio</option></select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="ser_fecha">Fecha del servicio</label>
                    <input type="date" name="ser_fecha" id="fecha_servicio" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="ser_hora_entrada">Hora de entrada</label>
                    <!-- CORRECCIÓN 2: Nombres de campos de hora corregidos -->
                    <input type="time" class="form-control" name="ser_hora_entrada" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="ser_hora_salida">Hora de salida</label>
                    <input type="time" class="form-control" name="ser_hora_salida" required>
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#135787; color: #ffffff"><i class="bi bi-caret-left"></i> Anterior</button>
                <button type="button" class="btn next-btn" style="background-color:#135787; color: #ffffff">Siguiente <i class="bi bi-caret-right"></i></button> 
            </div>
        </div>

        <!-- PASO 5: OBSERVACIONES Y FINALIZAR -->
        <div class="step" id="step5">
            <h5 class="mb-3">5. Observaciones Finales y Firmas</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="observaciones" class="form-label">Añade aquí cualquier detalle adicional, recomendación o trabajo realizado.</label>
                    <!-- CORRECCIÓN 3: Nombre del campo de observaciones corregido -->
                    <textarea name="ser_observaciones" id="observaciones" class="form-control" rows="5" required></textarea>
                </div>
            </div>
            <!-- Aquí puedes añadir los campos para las firmas y las fotos en el futuro -->
            <div class="text-center mt-4">
                <button type="button" class="btn prev-btn" style="background-color:#6c757d; color: #ffffff"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                <button type="submit" class="btn" style="background-color: #198754; color: #ffffff"><i class="bi bi-check-circle-fill"></i> Finalizar y Generar PDF</button>
            </div>
        </div>
    </form>
</div>

<footer>
    <div class="bg-primary">
        <?php
           // CORRECCIÓN: Rutas de inclusión robustas usando __DIR__
        require_once __DIR__ . '/../../../public/headerandfoother/foother1.php'; 
        ?>
    </div>
</footer>

<!-- SCRIPT PARA EL FORMULARIO MULTIPASOS -->
<script>
    // Pasamos las variables de PHP a JavaScript de forma segura
    const tiposDeServicio = <?= json_encode($tipos_servicio ?? []) ?>;
    const tiposDeInforme = <?= json_encode($tipos_informe ?? []) ?>;
</script>
<script src="../public/css/jsBoostrap/bootstrap.min.js"></script>
<script src="../public/js/formulariojs.js"></script>
<script src="../public/css/jsBoostrap/bootstrap.min.js "></script>

</body>
</html>
