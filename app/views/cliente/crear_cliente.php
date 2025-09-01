<?php
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) { /* ... */ }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '/../xampp/htdocs/softgenn/public/headerandfoother/admin_header.php'; ?>

       <main class="container py-5">
        <h1 class="mb-4">Crear Nuevo Cliente</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="/softGenn/public/index.php?action=crear_cliente" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6"><label for="razon_social" class="form-label">Razón Social</label><input type="text" class="form-control" id="razon_social" name="razon_social"  placeholder="frescaleche S.A.S" required></div>
                        <div class="col-md-6"><label for="cli_nit" class="form-label">NIT</label><input type="text" class="form-control" id="cli_nit" name="cli_nit" placeholder="995038399" required></div>
                        <div class="col-md-6"><label for="contacto_nombre" class="form-label">Nombre del Contacto</label><input type="text" class="form-control" id="contacto_nombre" name="contacto_nombre" placeholder="freskaleche" required></div>
                        <div class="col-md-6"><label for="direccion" class="form-label">Dirección</label><input type="text" class="form-control" id="direccion" name="direccion" placeholder="cra 33 #89-09" required></div>
                        <div class="col-md-6"><label for="contacto_correo" class="form-label">Contacto correo</label><input type="email" class="form-control" id="contacto_correo" name="contacto_correo" placeholder="freskaleche@gmail.com" required></div>
                        <div class="col-md-6"><label for="contacto_telefono" class="form-label">Contacto teléfono</label><input type="telefono" class="form-control" id="contacto_telefono" name="contacto_telefono" placeholder="324569770" required></div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                        <a href="/softGenn/public/index.php?action=gestionar_clientes" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>