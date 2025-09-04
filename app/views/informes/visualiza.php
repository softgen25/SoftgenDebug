<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">

    <link href= "https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="../public/css/cssBoostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/visualizacion.css">
</head>
<body>
    <header>
        <div class="bg-primary">
            <?php
                include __DIR__ . '/../../../public/headerandfoother/header1.php';
            ?>
        </div>
    </header>
    <nav class="MÓDULOS text-decoration-none " style="height: 70px;">
        <div class="container-fluid módulos text-center" id="navbarNav">
            <ul class="me-auto">
                <li><a class="nav-link text-decoration-none" href="#" onclick="mostrarPaso('step1')">Informes</a></li>
                <li><a class="nav-link text-decoration-none" href="#" onclick="mostrarPaso('step2')">Estados</a></li>
            </ul>
        </div>
    </nav>
    <div class="step active" id="step1">
        <section>
            <div class="container-fluid">
                <h4 class="mb-3">Detalles de los informes</h4>
            </div>
        </section>
    </div>
    <div class="step" id="step2">
        <div class="container-fluid">
            <h4 class="md-3">Estado de los informes</h4>
            <div class="table-respincive">
                <table class="table table-striped table-hover bg-white rounded shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th># informe</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Cliente</th>
                            <th>Estado anterior</th>
                            <th>Estado actual</th>
                            <th>Tecnico</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($datosHistorial)): ?>
                        <tr>
                        <td colspan="8" class="text-center py-4">No se han encontrado registros en el historial.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($datosHistorial as $registro): ?>
                            <tr>
                                <td><strong>#<?php echo htmlspecialchars($registro['id_servicio']); ?></strong></td>
                
                                <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                
                                <td><?php echo htmlspecialchars($registro['hora']); ?></td>
                
                                <td><?php echo htmlspecialchars($registro['nombre_cliente'] ?? 'N/A'); ?></td>
                
                                <td>
                                    <span class="badge bg-warning text-dark"><?php echo htmlspecialchars($registro['estado_anterior']); ?></span>
                                </td>

                                <td>
                                    <?php 
                                        $estado_actual = htmlspecialchars($registro['estado_actual'] ?? 'Pendiente');
                                    $badge_class = 'bg-secondary';
                                        if ($estado_actual == 'Firmado') $badge_class = 'bg-success';
                                        if ($estado_actual == 'Rechazado') $badge_class = 'bg-danger';
                                        if ($estado_actual == 'Pendiente') $badge_class = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?> "><?php echo $estado_actual ?></span> 
                                
                                </td>
                
                                <td><?php echo htmlspecialchars($registro['nombre_tecnico']); ?></td>

                                <td>Cambio de estado</td>

                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div> 
    </div> 
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?action=gestionar_informes=<?php echo $i; ?>&busqueda=<?php echo htmlspecialchars($busqueda ?? ''); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <footer>
        <div class="bg-primary">
            <?php
                require_once __DIR__ . '/../../../public/headerandfoother/foother1.php'; 
            ?>
        </div>
    </footer>
    <script src="../public/js/formulariojs.js"></script>
    <script>
        // Función para mostrar y ocultar los pasos
        function mostrarPaso(pasoId) {
            // Oculta todos los pasos
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'none';
            
            // Muestra solo el paso seleccionado
            document.getElementById(pasoId).style.display = 'block';
        }
        
        // Muestra el paso 1 por defecto al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            mostrarPaso('step1');
        });
    </script>
    <script src="../public/css/jsBoostrap/Bootstrap.min.js"></script>
</body>
</html>