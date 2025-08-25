<?php

namespace App\Controllers;

require_once __DIR__. '../../models/visualizacionmodel.php';

use PDO;
use app\Models\VisualizacionModel;

class visualizacioncontroller{
    private $db;
    private $visualizacionModel;


    public function __construct(PDO $db){
        $this->visualizacionModel = new visualizacionModel($db);
    }

    public function mostrarvisualizacion(){
        require_once '../app/view/usuario/visualizacion.php';
    }
}


?>