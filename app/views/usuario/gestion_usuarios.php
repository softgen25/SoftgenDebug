<?php
// Medida de Seguridad
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header('Location: index.php?action=login&error=' . urlencode('Acceso denegado.'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body style="background-color: #ececec;">
    <?php include '/../xampp/htdocs/softgenn/public/headerandfoother/admin_header.php'; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Usuarios y Técnicos</h1>
            <!--Alerta de usuario creado-->
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] === 'creado_usuario'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ✅ Usuario creado correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['status'] === 'eliminado'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        🗑️ Usuario eliminado correctamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif ($_GET['status'] === 'error' && isset($_GET['error_msg'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ❌ <?php echo htmlspecialchars($_GET['error_msg']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <a href="index.php?action=mostrar_crear_usuario" class="btn" style="background-color: #135787; color: #ffff;">
                <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Usuario
            </a>
        </div>
        <div class="card shadow pt-3 pb-3 pe-3 ps-3" >
        <!-- Formulario de Búsqueda -->
        <form action="index.php" method="get" class="mb-4">
            <input type="hidden" name="action" value="gestionar_usuarios">
            <div class="input-group">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre, apellido o correo..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                <button class="btn" style="background-color: #135787; color: #ffff;" type="submit"><i class="bi bi-search"></i> Buscar</button>
            </div>
        </form>

        <!-- Tabla de Usuarios -->
        <div class="table-responsive rounded">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron usuarios.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['usu_correo']); ?></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($usuario['rol_nombre']); ?></span></td>
                                <td><?php echo htmlspecialchars($usuario['usu_telefono']); ?></td>
                                <td>
                                    <a href="index.php?action=mostrar_editar_usuario&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    <a href="index.php?action=eliminar_usuario&id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
        <br>
        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?php echo ($paginaActual == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index.php?action=gestionar_usuarios&pagina=<?php echo $i; ?>&busqueda=<?php echo htmlspecialchars($busqueda ?? ''); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const error_msg = urlParams.get('error_msg');

            if (status === 'error' && error_msg) {
                alert(decodeURIComponent(error_msg));
            } else if (status === 'eliminado') {
                alert('Usuario eliminado exitosamente.');
            }
        });
</script>
</body>
</html>


