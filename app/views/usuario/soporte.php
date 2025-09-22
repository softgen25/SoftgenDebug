
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="/softgenn/public/css/soporteCss.css">
</head>
<body style="background-color: #ececec;">
<?php
  session_start();

  // Simular sesión de técnico solo para esta vista si no existe
  if (!isset($_SESSION['id_usuario'])) {
      $_SESSION['id_usuario'] = 0; // un valor ficticio, puede ser el ID real del usuario
  }

  if (!isset($_SESSION['id_rol'])) {
      $_SESSION['id_rol'] = 2; // rol técnico para que no redirija
  }

  // ahora sí incluyes el header
  require_once __DIR__ . '/../../../public/headerandfoother/header1.php';
?>
<div class="support-hero">
  <div class="container py-5">
    <div class="text-center text-dark">
      <h1 class="display-4 fw-bold mb-6" style="color: #E4F7FF; background-color: #135787; border-radius: 30px; display: inline-block; padding: 10px 25px;">SOPORTE SOFTGEN</h1><br><br><br>
      <a href="#" class="btn btn-lg rounded-pill mt-3" style="background-color: #E4F7FF; color: #135787; border-color: #135787" data-bs-toggle="modal" data-bs-target="#correoModal">Contactar</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="correoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
          <h5 class="modal-title">Correo de contacto</h5>
          <div class="modal-body">
            <p>softgen@softgenproject.pro</p>
            <p>softgen14@gmail.com</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #135787; color: #ffff">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-5 pb-5 pt-3 ps-1 pe-1 rounded border border-2" style="background-color: #ffff;">
  <h3 class="text-center">Desarrolladores</h3>
  
  <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
    <?php
    $usuarios = [
      "Edwin Montenegro",
      "Maria Jose Mendoza",
      "Dajaryth Hernandez",
      "Juan Gomez",
      "Harold Peñalosa"
    ];

    foreach ($usuarios as $desarrollador) {
      echo '
      <div class="d-flex align-items-center bg-light rounded-pill px-3 py-2 shadow-sm">
        <i class="bi bi-person-fill-gear" style="font-size: 40px; color: #135787; margin-right: 10px;"></i>
        
        <p class="fw-bold mb-0 text-white" 
           style="background-color:#135787; border-radius: 20px; padding: 5px 15px; margin-right: 10px;">
           Desarrollador
        </p>
        
        <small>' . $desarrollador . '</small>
      </div>';
    }
    ?>
  </div>
</div>
  </div>
</div>
<?php 
        require_once '/../xampp/htdocs/softgenn/public/headerandfoother/foother1.php';
        
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
