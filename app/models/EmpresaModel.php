<?php
namespace App\Models;
// app/models/EmpresaModel.php
use PDO;
class EmpresaModel {
    private $db;
    private $conn;

    public function __construct( PDO $db) {
        $this->db = $db;
    }

    /**
     * Obtiene todas las empresas de la base de datos.
     * @return array Una lista de todas las empresas.
     */
    public function obtenerEmpresa() {
        $query = "SELECT e.id_empresa, e.emp_razon_social AS razon_social
            FROM empresa e
            ORDER BY e.emp_razon_social ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function obtenerTodasPaginadoEmpresa($pagina = 1, $porPagina = 15, $busqueda = '') {
        $offset = ($pagina - 1) * $porPagina;
        $sqlBusqueda = '';
        $params = [];

        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE emp_razon_social LIKE ? OR emp_nit LIKE ?";
            $searchTerm = "%$busqueda%";
            $params = [$searchTerm, $searchTerm];
        }

        $sql = "SELECT * FROM empresa 
                $sqlBusqueda
                ORDER BY emp_razon_social ASC 
                LIMIT " . (int)$porPagina . " OFFSET " . (int)$offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cuenta el total de empresas para la paginación.
     */
    public function contarTodasEmpresa($busqueda = '') {
        $sqlBusqueda = '';
        $params = [];
        if (!empty($busqueda)) {
            $sqlBusqueda = "WHERE emp_razon_social LIKE ? OR emp_nit LIKE ?";
            $searchTerm = "%$busqueda%";
            $params = [$searchTerm, $searchTerm];
        }

        $sql = "SELECT COUNT(*) FROM empresa $sqlBusqueda";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    /**
     * Obtiene una empresa por su ID.
     */
    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM empresa WHERE id_empresa = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva empresa dentro de una transacción para mayor seguridad.
     */
    public function crear($datos) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO empresa (emp_razon_social, emp_nit, emp_correo, emp_telefono) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute([
                $datos['emp_razon_social'],
                $datos['emp_nit'],
                $datos['emp_correo'],
                $datos['emp_telefono']
            ]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Error al crear empresa: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de una empresa dentro de una transacción.
     */
    public function actualizar($id, $datos) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE empresa SET emp_razon_social = ?, emp_nit = ?, emp_correo = ?, emp_telefono = ? WHERE id_empresa = ?";
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute([
                $datos['emp_razon_social'],
                $datos['emp_nit'],
                $datos['emp_correo'],
                $datos['emp_telefono'],
                $id
            ]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log("Error al actualizar empresa: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una empresa por su ID.
     */
    public function eliminar($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM empresa WHERE id_empresa = ?");
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            error_log("Error al eliminar empresa: " . $e->getMessage());
            return false;
        }
    }
}
