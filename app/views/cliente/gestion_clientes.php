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
    <title>Gestión de Clientes - SoftGen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body style="background-color: #ececec;">
    <?php include '/../xampp/htdocs/softgenn/public/headerandfoother/admin_header.php'; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Clientes</h1>
            <a href="/softGenn/public/index.php?action=mostrar_crear_cliente" class="btn" style="background-color: #135787; color: #ffff;">
                <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Cliente
            </a>
        </div>

        <!-- Mensajes de alerta para el usuario -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'creado_cliente'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ Cliente creado correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['status'] === 'cliente_eliminado'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ Cliente eliminado correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['status'] === 'eliminar_fallido'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    ⚠️ No puedes eliminar este cliente porque tiene servicios asociados.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ Ocurrió un error inesperado al intentar eliminar el cliente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <form action="/softGenn/public/index.php" method="get" class="mb-4">
                    <input type="hidden" name="action" value="gestionar_clientes">
                    <div class="input-group">
                        <input type="text" name="busqueda" class="form-control" placeholder="Buscar por razón social, NIT o contacto..." value="<?php echo htmlspecialchars($busqueda ?? ''); ?>">
                        <button class="btn" style="background-color: #135787; color: #ffff;" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>

                <div class="table-responsive rounded">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Razón Social</th>
                                <th>NIT</th>
                                <th>Contacto</th>
                                <th>Dirección</th>
                                <th>Contacto telefono</th>
                                <th>Contacto Correo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if (empty($clientes)): ?>
                                <tr><td colspan="6" class="text-center">No se encontraron clientes.</td></tr>
                            <?php else: ?>
                                <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                        <!-- **CORRECCIÓN 2: Uso del operador ?? '' para evitar valores null** -->
                                        <td><?php echo htmlspecialchars($cliente['razon_social'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['cli_nit'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_nombre'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_telefono'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['contacto_correo'] ?? ''); ?></td>
                                        <td>
                                            <a href="/softGenn/public/index.php?action=mostrar_editar_cliente&id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="/softGenn/public/index.php?action=eliminar_cliente&id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro? Esta acción no se puede deshacer.');"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>">
                                <a class="page-link" style="background-color: #135787; color: #ffff" href="/softGenn/public/index.php?action=gestionar_clientes&pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda ?? ''); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </main>
</div>
</body>
</html>
