<?php

namespace App\Controllers;

require_once __DIR__. '/../models/visualizacionmodel.php';
require_once __DIR__. '../../models/UsuarioModel.php';

// ... otros controladores


use PDO;
use App\Models\VisualizacionModel;
use App\Models\UsuarioModel;

class Visualizacioncontroller{
    private $db;
    private $visualizacionModel;
    private $datosHistorial;


    public function __construct(PDO $db){
        $this->visualizacionModel = new VisualizacionModel($db);
        
    }

    public function mostrarvisualizacion(){
        require_once __DIR__. '/../views/usuario/visualiza.php';
    }

    public function mostrarHistorial(){
        $datosHistorial = $this->visualizacionModel->obtenerHistorialDeCambios();

        require_once __DIR__. '/../views/informes/visualiza.php';
    }





}


?>