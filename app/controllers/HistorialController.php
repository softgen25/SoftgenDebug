<?php

namespace App\Controllers;

require_once __DIR__. '/../models/HistorialModel.php';
require_once __DIR__. '../../models/UsuarioModel.php';

// ... otros controladores


use PDO;
use App\Models\HistorialModel;
use App\Models\UsuarioModel;

class HistorialController{
    private $db;
    private $historialModel;
    private $datosHistorial;


    public function __construct(PDO $db){
        $this->historialModel = new HistorialModel($db);

    }

    public function mostrarvisualizacion(){
        require_once __DIR__. '/../views/usuario/visualiza.php';
    }

    public function mostrarHistorial(){
        $datosHistorial = $this->historialModel->obtenerHistorialDeCambios();

        require_once __DIR__. '/../views/informes/visualiza.php';
    }





}


?>