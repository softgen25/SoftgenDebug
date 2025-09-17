<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php 

  include __DIR__ .'/../../../public/headerandfoother/header1.php';

 ?>

<div class="support-hero">
  <div class="container py-5">
    <div class="text-center text-dark">
      <h1 class="display-4 fw-bold">SOPORTE SOFTGEN</h1>
      <a href="mailto:softgendg547@gmail.com" class="btn btn-dark btn-lg rounded-pill mt-3">Contactar</a>
    </div>

    <div class="mt-5">
      <h3 class="text-center text-dark">Desarrolladores</h3>
      <div class="d-flex flex-wrap justify-content-center gap-4 mt-4">
        <?php
        $usuarios = [
          "Edwin Montenegro",
          "Maria Jose Mendoza",
          "Dajaryth Hernandez",
          "Juan Gomez",
          "Harold Peñalosa"
        ];

        foreach ($usuarios as $usuario) {
            echo '
            <div class="text-center text-dark">
              <img src="usuarios/person-fill-gear.svg." width="60" height="60" alt="Usuario">
              <p class="mb-0 fw-bold">Usuario</p>
              <small>' . $usuario . '</small>
            </div>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
