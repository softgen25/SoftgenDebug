<?php
// Funciones auxiliares para mejorar la presentación de los datos en el PDF
function checkmark($value) {
    return $value ? 'Sí' : 'No';
}

function estadoMecanico($value) {
    $estados = [1 => 'Bueno', 2 => 'Regular', 3 => 'Malo', 4 => 'Requiere Cambio'];
    return $estados[$value] ?? 'N/A';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Servicio #<?= htmlspecialchars($informe['id_servicio'] ?? 'N/A') ?></title>
    <style>
        /* --- ESTILOS GENERALES Y FUENTES --- */
        @page {
            margin-header: 15mm;
            margin-footer: 15mm;
            header: html_myHeader;
            footer: html_myFooter;
        }
        body {
            font-family: 'Saira', sans-serif;
            font-size: 11px;
            color: #333;
        }
        h1, h2, h3, h4 {
            font-weight: 600;
            color: #135787;
        }
        h2 {
            font-size: 16px;
            border-bottom: 2px solid #135787;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        /* --- ESTRUCTURA Y CONTENEDORES --- */
        .container {
            width: 100%;
        }
        .section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }
        .section-light {
            background-color: #f9f9f9;
        }

        /* --- TABLAS --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #135787;
            color: white;
            font-weight: 600;
        }
        .table-striped tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd;
        }

        /* --- LAYOUT DE DOS COLUMNAS --- */
        .two-columns {
            width: 100%;
        }
        .col-left {
            width: 48%;
            float: left;
        }
        .col-right {
            width: 48%;
            float: right;
        }
        .clear {
            clear: both;
        }
        
        /* --- CLASES DE UTILIDAD --- */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .label { font-weight: 600; color: #555; }
        .data-box {
            padding: 10px;
            background-color: #eef4f8;
            border-left: 4px solid #135787;
            margin-bottom: 10px;
        }
        .data-box p { margin: 0; padding: 2px 0; }

    </style>
</head>
<body>

    <!-- ENCABEZADO PERSONALIZADO PARA MPDF -->
    <htmlpageheader name="myHeader">
        <table width="100%">
            <tr>
                <td width="50%" style="vertical-align: middle;">
                    <!-- Asegúrate de que la ruta a tu logo sea correcta -->
                    <img src="../../public/img/Logo_reporte.png" width="180" alt="Logo">
                </td>
                <td width="50%" style="text-align: right; vertical-align: middle;">
                    <h1>INFORME DE SERVICIO TÉCNICO</h1>
                    <p style="margin:0;"><strong>No. Reporte:</strong> <?= htmlspecialchars($informe['id_servicio'] ?? 'N/A') ?><br>
                    <strong>Fecha de Emisión:</strong> <?= date('d/m/Y') ?></p>
                </td>
            </tr>
        </table>
        <hr>
    </htmlpageheader>

    <!-- PIE DE PÁGINA PERSONALIZADO PARA MPDF -->
    <htmlpagefooter name="myFooter">
        <hr>
        <table width="100%">
            <tr>
                <td width="33%">SoftGenn</td>
                <td width="33%" align="center">Página {PAGENO} de {nbpg}</td>
                <td width="33%" style="text-align: right;">www.softgenn.com</td>
            </tr>
        </table>
    </htmlpagefooter>

    <!-- CUERPO DEL DOCUMENTO -->
    <div class="container">

        <h2>1. Información General</h2>
        <div class="two-columns section section-light">
            <div class="col-left">
                <h4>Datos del Cliente</h4>
                <p><span class="label">Razón Social:</span> <?= htmlspecialchars($cliente['razon_social'] ?? 'N/A') ?></p>
                <p><span class="label">NIT:</span> <?= htmlspecialchars($cliente['cli_nit'] ?? 'N/A') ?></p>
                <p><span class="label">Contacto:</span> <?= htmlspecialchars($cliente['contacto_nombre'] ?? 'N/A') ?></p>
                <p><span class="label">Teléfono:</span> <?= htmlspecialchars($cliente['contacto_telefono'] ?? 'N/A') ?></p>
                <p><span class="label">Dirección:</span> <?= htmlspecialchars($informe['cliente_direccion'] ?? 'N/A') ?></p>
            </div>
            <div class="col-right">
                <h4>Detalles del Servicio</h4>
                <p><span class="label">Tipo de Servicio:</span> <?= htmlspecialchars($informe['ser_tipo_servicio'] ?? 'N/A') ?></p>
                <p><span class="label">Tipo de Informe:</span> <?= htmlspecialchars($informe['ser_tipo_informe'] ?? 'N/A') ?></p>
                <p><span class="label">Fecha de Servicio:</span> <?= date('d/m/Y', strtotime($informe['fecha_servicio'] ?? 'now')) ?></p>
                <p><span class="label">Hora de Entrada:</span> <?= date('h:i A', strtotime($informe['ser_hora_entrada'] ?? 'now')) ?></p>
                <p><span class="label">Hora de Salida:</span> <?= date('h:i A', strtotime($informe['ser_hora_salida'] ?? 'now')) ?></p>
                <p><span class="label">Técnico Asignado:</span> <?= htmlspecialchars($tecnico['usu_nombre'] . ' ' . $tecnico['usu_apellido'] ?? 'N/A') ?></p>
            </div>
            <div class="clear"></div>
        </div>

        <h2>2. Equipo(s) Intervenido(s)</h2>
        <?php if (!empty($equipos)): ?>
            <table class="table-striped">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Serie</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipos as $equipo): ?>
                    <tr>
                        <td><?= htmlspecialchars($equipo['equi_tipo_equipo']) ?></td>
                        <td><?= htmlspecialchars($equipo['equi_marca']) ?></td>
                        <td><?= htmlspecialchars($equipo['equi_modelo']) ?></td>
                        <td><?= htmlspecialchars($equipo['equi_serie']) ?></td>
                        <td><?= htmlspecialchars($equipo['equi_ubicacion']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se registraron equipos para este servicio.</p>
        <?php endif; ?>

        <h2>3. Checklist de Inspección y Mediciones</h2>
        <div class="two-columns">
            <div class="col-left">
                <table class="table-bordered">
                    <tr><td class="label">Goteras</td> <td><?= checkmark($inspeccion['ig_goteos'] ?? 0) ?></td></tr>
                    <tr><td class="label">Gabinete</td> <td><?= checkmark($inspeccion['ig_gabinete'] ?? 0) ?></td></tr>
                    <tr><td class="label">Filtro</td> <td><?= checkmark($inspeccion['ig_filtro'] ?? 0) ?></td></tr>
                    <tr><td class="label">Drenaje</td> <td><?= checkmark($inspeccion['ig_drenaje'] ?? 0) ?></td></tr>
                    <tr><td class="label">Serpentin</td> <td><?= checkmark($inspeccion['ig_serpentin'] ?? 0) ?></td></tr>
                    <tr><td class="label">Fuga de Refrigerante</td> <td><?= checkmark($inspeccion['ig_refrigerante'] ?? 0) ?></td></tr>
                    <tr><td class="label">Vibración Anormal</td> <td><?= checkmark($inspeccion['ig_vibracion'] ?? 0) ?></td></tr>
                    <tr><td class="label">Tablero Electrico</td> <td><?= checkmark($inspeccion['ig_tablero_electrico'] ?? 0) ?></td></tr>
                    <tr><td class="label">Aislamiento</td> <td><?= checkmark($inspeccion['ig_aislamiento_gabinete'] ?? 0) ?></td></tr>
                    <tr><td class="label">Flujo de Aire</td> <td><?= checkmark($inspeccion['ig_flujo_aire'] ?? 0) ?></td></tr>
                </table>
            </div>
            <div class="col-right">
                <div class="data-box">
                    <h4>Mediciones Eléctricas y de Temperatura</h4>
                    <p><span class="label">Amperaje (A):</span> <?= htmlspecialchars($inspeccion['ig_amperios'] ?? 'N/A') ?></p>
                    <p><span class="label">Voltaje (V):</span> <?= htmlspecialchars($inspeccion['ig_voltaje'] ?? 'N/A') ?></p>
                    <p><span class="label">Temp. Suministro (°C):</span> <?= htmlspecialchars($inspeccion['ig_temp_suministro'] ?? 'N/A') ?></p>
                    <p><span class="label">Temp. Retorno (°C):</span> <?= htmlspecialchars($inspeccion['ig_temp_retorno'] ?? 'N/A') ?></p>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <h2>4. Revisión Mecánica</h2>
        <table class="table-bordered table-striped">
             <thead>
                <tr>
                    <th>Componente</th><th>Estado</th>
                    <th>Componente</th><th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label">Ejes</td><td><?= estadoMecanico($informe['rm_ejes'] ?? 0) ?></td>
                    <td class="label">Correas</td><td><?= estadoMecanico($informe['rm_correas'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td class="label">Rodamientos</td><td><?= estadoMecanico($informe['rm_rodamientos'] ?? 0) ?></td>
                    <td class="label">Rejillas</td><td><?= estadoMecanico($informe['rm_rejillas'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td class="label">Chumaceras</td><td><?= estadoMecanico($informe['rm_chumaceras'] ?? 0) ?></td>
                    <td class="label">Pintura</td><td><?= estadoMecanico($informe['rm_pintura'] ?? 0) ?></td>
                </tr>
                <tr>
                    <td class="label">Poleas</td><td><?= estadoMecanico($informe['rm_poleas'] ?? 0) ?></td>
                    <td class="label">Ductos</td><td><?= estadoMecanico($informe['rm_ductos'] ?? 0) ?></td>
                </tr>
            </tbody>
        </table>
        
        <h2>5. Observaciones y Recomendaciones</h2>
        <div class="section section-light">
            <p><?= nl2br(htmlspecialchars($informe['ser_observaciones'] ?? 'Sin observaciones.')) ?></p>
        </div>

        <h2>6. Firmas de Conformidad</h2>
        <div class="two-columns" style="margin-top: 40px;">
            <div class="col-left text-center">
                <p>_________________________</p>
                <p><span class="label">Firma del Técnico</span><br><?= htmlspecialchars($tecnico['usu_nombre'] . ' ' . $tecnico['usu_apellido'] ?? 'N/A') ?></p>
            </div>
            <div class="col-right text-center">
                <p>_________________________</p>
                <p><span class="label">Firma del Cliente</span><br><?= htmlspecialchars($cliente['contacto_nombre'] ?? 'N/A') ?></p>
            </div>
            <div class="clear"></div>
        </div>

    </div>
</body>
</html>
