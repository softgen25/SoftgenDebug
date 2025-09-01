<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <section>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($datosHistorial)): ?>
                    <tr>
                       <td colspan="9" class="text-center py-4">No se han encontrado registros en el historial.</td>
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
                
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Ver Informe"><i class="bi bi-eye-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <script src="../public/css/jsBoostrap/Bootstrap.min.js"></script>
</body>
</html>