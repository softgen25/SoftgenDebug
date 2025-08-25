<?php
namespace App\Models;

use PDO;

class VisualizacionModel{
    private $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }
}