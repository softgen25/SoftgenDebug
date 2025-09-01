<?php

namespace App\Controllers;

require_once __DIR__. '/../models/visualizacionmodel.php';
// ... otros controladores


use PDO;
use App\Models\VisualizacionModel;

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

        require_once __DIR__. '/../views/usuario/visualiza.php';
    }

    
}


?>