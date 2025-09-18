<?php
// Medida de Seguridad Esencial
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso denegado.'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - SoftGen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <!---<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/css/cssBoostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/cssBoostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../public/css/jsBoostrap/bootstrap.min.js">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.min.js"
        integrity="sha512-5vwN8yor2fFT9pgPS9p9R7AszYaNn0LkQElTXIsZFCL7ucT8zDCAqlQXDdaqgA1mZP47hdvztBMsIoFxq/FyyQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        body {
            font-family: 'Saira', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            padding: 20px;
            background-color: #212529;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            font-size: 1.1rem;
            padding: 10px 15px;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: #fff;
            background-color: #343a40;
        }
        .sidebar .nav-link .bi {
            margin-right: 10px;
        }
        .sidebar .logo {
            margin-bottom: 30px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .stat-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }

        .stat-card-link {
            text-decoration: none; /* Quita el subrayado del enlace */
            transition: transform 0.2s ease-in-out; /* Animación suave */
        }

        .stat-card-link:hover .stat-card {
            transform: translateY(-5px); /* Eleva la tarjeta al pasar el ratón */
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15); /* Sombra más pronunciada */
        }

        /* estilos.css de las tarjetas*/

        .bg-custom-informes {
        background-color: #4AA9D9 !important; /* Reemplaza con tu código de color */
        }

        .bg-custom-tecnicos {
        background-color: #135787 !important; /* Reemplaza con tu código de color */
        }

        .bg-custom-clientes {
        background-color: #4AA9D9 !important; /* Reemplaza con tu código de color */
        }

        .bg-custom-pendientes {
        background-color: #135787 !important; /* Reemplaza con tu código de color */
        }

        /* Opcional: Asegura que el texto sea visible en colores oscuros */
        .text-dark {
            color: #212529 !important;
        }
        .text-white {
            color: #fff !important;
        }

        /* Opcional: Estilo para que los enlaces no tengan subrayado */
        .stat-card-link {
            text-decoration: none;
        }
    </style>
</head>
<header>
    <div class="bg-primary">
        <?php
            include '/../xampp/htdocs/softgenn/public/headerandfoother/admin_header.php';
        ?>
    </div>
    
</header>
<body style="background-color: #ececec;">
    <!-- Barra de Navegación Lateral (Sidebar) -->
    
    <!-- Contenido Principal -->
    <main class="main-content">
        <h1 class="mb-4">Dashboard de Administración</h1>

        <!-- Tarjetas de Estadísticas -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-lg-3">
        <a href="/softGenn/public/index.php?action=gestionar_informes" class="stat-card-link">
            <div class="card bg-custom-informes text-white stat-card">
                <div class="card-body d-flex justify-content-between align-items-center shadow-sm">
                    <div>
                        <h3 class="fs-2 fw-bold mb-0"><?php echo htmlspecialchars($estadisticas['total_informes']); ?></h3>
                        <p class="mb-0 opacity-75">Informes realizados</p>
                    </div>
                    <i class="bi bi-file-earmark-text-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="../public/index.php?action=gestionar_usuarios" class="stat-card-link">
            <div class="card bg-custom-tecnicos text-white stat-card">
                <div class="card-body d-flex justify-content-between align-items-center shadow-sm">
                    <div>
                        <h3 class="fs-2 fw-bold mb-0"><?php echo htmlspecialchars($estadisticas['total_tecnicos']); ?></h3>
                        <p class="mb-0 opacity-75">Técnicos conectados</p>
                    </div>
                    <i class="bi bi-person-check-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="/softGenn/public/index.php?action=gestionar_clientes" class="stat-card-link">
            <div class="card bg-custom-clientes text-white stat-card">
                <div class="card-body d-flex justify-content-between align-items-center shadow-sm">
                    <div>
                        <h3 class="fs-2 fw-bold mb-0"><?php echo htmlspecialchars($estadisticas['total_clientes']); ?></h3>
                        <p class="mb-0 opacity-75">Clientes vinculados</p>
                    </div>
                    <i class="bi bi-building fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="/softGenn/public/index.php?action=gestionar_informes" class="stat-card-link">
            <div class="card bg-custom-pendientes text-white stat-card"> <div class="card-body d-flex justify-content-between align-items-center shadow-sm">
                    <div>
                        <h3 class="fs-2 fw-bold mb-0"><?php echo htmlspecialchars($estadisticas['informes_pendientes']); ?></h3>
                        <p class="mb-0 opacity-75">Informes pendientes</p>
                    </div>
                    <i class="bi bi-pen-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </a>
    </div>
</div>
        <!-- Gráficos y Acciones Críticas -->
<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card stat-card" style="height: 500px;">
                <div class="card-body d-flex flex-column shadow">
                    <h5 class="card-title">Informes por Tipo de Servicio</h5>
                    <div class="flex-grow-1" style="position: relative;">
                        <canvas id="informesChart"></canvas> 
                    </div>
                    <button onclick="actualizar()" class="btn mt-3 w-50 align-self-center mb-3" style="background-color: #135787; color: #ffff;">Actualizar tabla</button>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card stat-card">
                <div class="card-body d-flex flex-column shadow">
                    <h5 class="card-title">Estado de Servicios</h5>
                    <div style="position: relative; max-width: 400px; margin: 0 auto;">
                        <canvas id="estadoServiciosChart"></canvas>
                    </div>
                    <button onclick="actualizar()" class="btn mt-3 mb-3 w-50 align-self-center" style="background-color: #135787; color: #ffff;">Actualizar tabla</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var ctx1 = document.getElementById('informesChart').getContext('2d');
var informesBarChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Refrigerante Variable', 'Expansion directa', 'Condesado por agua', 'Ventilacion mecanica', 'otro'],
        datasets: [{
            label: 'Refrigerante Variable',
            data: [1, 0, 0, 0, 0], // El valor '1' está en la posición 0, las demás en 0
            backgroundColor: "#135787"
        },
        {
            label: 'Expansion directa',
            data: [0, 3, 0, 0, 0], // El valor '3' está en la posición 1, las demás en 0
            backgroundColor: "#03144F"
        },
        {
            label: 'Condesado por agua',
            data: [0, 0, 2, 0, 0], // El valor '2' está en la posición 2, las demás en 0
            backgroundColor: '#4AA9D9'
        },
        {
            label: 'Ventilacion mecanica',
            data: [0, 0, 0, 4, 0], // El valor '4' está en la posición 3, las demás en 0
            backgroundColor: "#8fb3e2"
        },
        {
            label: 'otro',
            data: [0, 0, 0, 0, 2], // El valor '2' está en la posición 4, las demás en 0
            backgroundColor: '#31487A'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

    var ctx2 = document.getElementById('estadoServiciosChart').getContext('2d'); 
    var estadoPieChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Pendiente', 'Firmado', 'Rechazado'],
            datasets: [{
                label: 'Estado',
                data: [3, 2, 1],
                backgroundColor: [
                    '#1f2124',
                    '#393d42',
                    '#6a6e73'
                ],
                hoverBackgroundColor: [
                    '#1f2124',
                    '#393d42',
                    '#6a6e73'
                ],
                bodercolor: '#ffffff',
                borderWidth: 2
            }]          
        },
        options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
                }
            }
        }
    });
    
    function actualizar() {
        informesBarChart.update();
        estadoDoughnutChart.update();
        console.log("Gráficos actualizados");
    }
</script>

        <!-- Tabla de Últimos Informes -->
        <div class="card stat-card shadow">
            <div class="card-header">
                <h5 class="mb-0">Últimos Informes Registrados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th><th>Cliente</th><th>Técnico</th><th>Fecha</th><th>Estado</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($actividadReciente)): ?>
                                <tr><td colspan="6" class="text-center">No hay informes recientes.</td></tr>
                            <?php else: ?>
                                <?php foreach ($actividadReciente as $actividad): ?>
                                    <tr>
                                        <td><strong>#<?php echo htmlspecialchars($actividad['id_servicio']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($actividad['nombre_cliente']); ?></td>
                                        <td><?php echo htmlspecialchars($actividad['usu_nombre'] . ' ' . $actividad['usu_apellido']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($actividad['ser_fecha'])); ?></td>
                                        <td>
                                            <?php 
                                                $estado = htmlspecialchars($actividad['ser_estado'] ?? 'Pendiente');
                                                $badge_class = 'bg-secondary';
                                                if ($estado == 'Firmado') $badge_class = 'bg-success';
                                                if ($estado == 'Rechazado') $badge_class = 'bg-danger';
                                                if ($estado == 'Pendiente') $badge_class = 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?php echo $badge_class; ?>"><?php echo $estado; ?></span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye-fill"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Librería para Gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- DATOS REALES DESDE PHP ---
            // Convertimos los arrays de PHP a objetos de JavaScript de forma segura.
            const datosTipoPHP = <?php echo json_encode($estadisticas['informes_por_tipo'] ?? []); ?>;
            const labelsTipo = Object.keys(datosTipoPHP);
            const dataTipo = Object.values(datosTipoPHP);

            const datosEstadoPHP = <?php echo json_encode($estadisticas['informes_por_estado'] ?? []); ?>;
            const labelsEstado = Object.keys(datosEstadoPHP);
            const dataEstado = Object.values(datosEstadoPHP);

            // Gráfico de Barras: Informes por Tipo
           /* const chartTipo = document.getElementById('informesPorTipoChart');
            if (chartTipo && labelsTipo.length > 0) {
                new Chart(chartTipo, {
                    type: 'bar',
                    data: {
                        labels: labelsTipo,
                        datasets: [{
                            label: 'Nº de Informes',
                            data: dataTipo,
                            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#0dcaf0', '#6f42c1', '#fd7e14']
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                });
            }

            // Gráfico de Dona: Estado de Servicios
           /* const chartEstado = document.getElementById('estadoServiciosChart');
            if (chartEstado && labelsEstado.length > 0) {
                new Chart(chartEstado, {
                    type: 'doughnut',
                    data: {
                        labels: labelsEstado,
                        datasets: [{
                            data: dataEstado,
                            backgroundColor: ['#198754', '#ffc107', '#dc3545', '#6c757d'] // Colores para Firmado, Pendiente, Rechazado, etc.
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } } }
                });
            }*/
        });
    </script>
    <script src="../public/css/jsBoostrap/bootstrap.min.js"></script> 
</body>
</html>