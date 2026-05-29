<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: /softGenn/public/index.php?action=login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empresas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="16x16" href="public/img/Logo Favicon 16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="public/img/Logo favicon 1.0.png">
    <link rel="icon" type="image/png" sizes="180x180" href="public/img/Logo Favicon 180x180.png">

</head>
<body style="background-color: #ececec;">

    <?php include '/../xampp/htdocs/softgenn/public/headerandfoother/admin_header.php'; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Empresas</h1>
            <a href="/softGenn/public/index.php?action=mostrar_crear_empresa" class="btn" style="background-color: #135787; color: #ffff;">
                <i class="bi bi-plus-circle-fill me-2"></i>Agregar Empresa
            </a>
        </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'creado'): ?>
        <div class="alert alert-success">Empresa creada exitosamente.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'editado'): ?>
        <div class="alert alert-success">Empresa actualizada exitosamente.</div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'eliminado'): ?>
        <div class="alert alert-success">Empresa eliminada exitosamente.</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                if ($_GET['error'] === 'eliminar_fallido') {
                    echo "Error: No se puede eliminar la empresa porque tiene registros asociados.";
                } else {
                    echo "Ocurrió un error al procesar la solicitud.";
                }
            ?>
        </div>
    <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <!-- FORMULARIO DE BÚSQUEDA CORREGIDO -->
                <form action="/softGenn/public/index.php" method="get" class="mb-4">
                    <input type="hidden" name="action" value="gestionar_empresas">
                    <div class="input-group">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por razón social o NIT..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                        <button class="btn" style="background-color: #135787; color: #ffff;" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            <div class="table-responsive rounded">
                <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Razón Social</th>
                        <th>NIT</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empresas as $empresa): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($empresa['emp_razon_social']); ?></td>
                        <td><?php echo htmlspecialchars($empresa['emp_nit']); ?></td>
                        <td><?php echo htmlspecialchars($empresa['emp_correo']); ?></td>
                        <td><?php echo htmlspecialchars($empresa['emp_telefono']); ?></td>
                        <td>
                            <a href="index.php?action=mostrar_editar_empresa&id=<?php echo $empresa['id_empresa']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="index.php?action=eliminar_empresa&id=<?php echo $empresa['id_empresa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta empresa?');">Eliminar</a>
                        </td>
                    </tr>
                     <?php endforeach; ?>
                </tbody>
                </table>
            </div>

        
        </div>

    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                <a class="page-link" style="background-color: #135787; color: #ffff;" href="index.php?action=gestionar_empresas&pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda ?? ''); ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
</div>
</body>
</html>
