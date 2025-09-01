<?php
namespace App\Models;

use PDO;

class VisualizacionModel{
    private $db;

    public function __construct(PDO $db){
        $this->db = $db;
    }

    public function obtenerHistorialDeCambios(){
        $sql = "SELECT
                    h.id_servicio,
                    DATE(h.fecha_cambio) AS fecha,
                    TIME(h.fecha_cambio) AS hora,
                    c.razon_social AS nombre_cliente,
                    h.estado_anterior,
                    h.estado_nuevo AS estado_actual,

                    CONCAT(u.usu_nombre, '', u.usu_apellido) AS nombre_tecnico
                
                FROM
                    historial_servicio h
                LEFT JOIN
                    servicio s ON h.id_servicio = s.id_servicio
                LEFT JOIN
                    cliente c On s.id_cliente = c.id_cliente
                LEFT JOIN
                    tecnico t ON h.id_tecnico_responsable = t.id_tecnico
                LEFT JOIN
                    usuario u ON t.id_usuario = u.id_usuario
                ORDER BY
                    h.id_historial DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                

    }
}