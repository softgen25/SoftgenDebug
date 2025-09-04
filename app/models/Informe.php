<?php
// ===== models/Informe.php =====
namespace App\Models;
use PDO;

class Informe {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function crear(array $data) {
        $query = "INSERT INTO informe (id_servicio, info_contenido, info_ruta_pdf, created_at, updated_at) 
                VALUES (:id_servicio, :info_contenido, :info_ruta_pdf, NOW(), NOW())";
        
        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":id_servicio", $data['id_servicio'], PDO::PARAM_INT);
        $stmt->bindValue(":info_contenido", $data['info_contenido']);
        $stmt->bindValue(":info_ruta_pdf", $data['info_ruta_pdf']);
        
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function obtenerPorServicioId(int $id_servicio) {
        $query = "SELECT * FROM informe WHERE id_servicio = :id_servicio ORDER BY id_informe DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function contarTodos($busqueda = '') {
        $sqlBusqueda = '';
        $params = [];
        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE s.id_servicio ? OR h.id_tecnico LIKE ? OR h.estado_anterior LIKE ? OR h.estado_nuevo";
            $params = ["%$busqueda%", "%$busqueda%", "%$busqueda%"];
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM usuario $sqlBusqueda");
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

        public function obtenerpaginados($pagina, $porPagina, $busqueda = '') {
        $offset = ($pagina - 1) * $porPagina;
        $sqlBusqueda = '';
        $params = [];
        $paramIndex = 1;

        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE s.id_servicio LIKE ? h.id_tecnico_responsable LIKE ? OR h.estado_anterior LIKE ? OR h.estado_nuevo";
            $params = ["%$busqueda%", "%$busqueda%", "%$busqueda%"];
        }

        $sql = "SELECT u.*, r.rol_nombre 
                FROM servicio u 
                JOIN rol r ON u.id_rol = r.id_rol 
                $sqlBusqueda
                ORDER BY s.id_servicio DESC 
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);

        // Vincular los parámetros de búsqueda (si existen)
        foreach ($params as $value) {
            $stmt->bindValue($paramIndex++, $value);
        }

        // Vincular los parámetros de paginación (LIMIT y OFFSET) como enteros
        $stmt->bindValue($paramIndex++, $porPagina, PDO::PARAM_INT);
        $stmt->bindValue($paramIndex, $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>