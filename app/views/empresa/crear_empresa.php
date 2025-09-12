<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<?php include '../public/headerandfoother/admin_header.php'; ?>
<body style="background-color: #ececec;">
    <div class="container mt-5">

        <h1>Crear Nueva Empresa</h1>
        <!--Alerta de verificarCorreo-->
        <?php if (isset($_GET['status']) && $_GET['status'] === 'correo_existente_empresa'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                El correo ya está registrado. Intenta con otro.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body">
                <form action="index.php?action=crear_empresa" method="POST">
                    <div class="form-group">
                        <label for="emp_razon_social">Razón Social</label>
                        <input type="text" class="form-control" id="emp_razon_social" name="emp_razon_social" required>
                    </div>
                    <div class="form-group">
                        <label for="emp_nit">NIT</label>
                        <input type="text" class="form-control" id="emp_nit" name="emp_nit" required>
                    </div>
                    <div class="form-group">
                        <label for="emp_correo">Correo Electrónico</label>
                        <input type="email" class="form-control" id="emp_correo" name="emp_correo" required>
                    </div>
                    <div class="form-group">
                        <label for="emp_telefono">Teléfono</label>
                        <input type="text" class="form-control" id="emp_telefono" name="emp_telefono" required>
                    </div>

                    <button type="submit" class="btn" style="background-color: #135787; color: #ffff;">Guardar Empresa</button>
                    <a href="index.php?action=gestionar_empresas" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>


</body>
</html>