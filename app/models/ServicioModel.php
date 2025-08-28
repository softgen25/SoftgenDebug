<?php
// ===== app/models/ServicioModel.php (VERSIÓN COMPLETA Y ADAPTADA A TU BD) =====
namespace App\Models;

use PDO;
use Exception;

class ServicioModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Obtiene los valores permitidos del campo ENUM 'ser_tipo_servicio'.
     * @return array Una lista de los tipos de servicio.
     */
    public function mostrarTipoServicio(): array {
        $query = "SHOW COLUMNS FROM servicio WHERE Field = 'ser_tipo_servicio'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['Type'])) {
            preg_match_all("/'([^']+)'/", $row['Type'], $matches);
            return $matches[1] ?? [];
        }
        return [];
    }

    /**
     * Obtiene los valores permitidos del campo ENUM 'ser_tipo_informe'.
     * @return array Una lista de los tipos de informe.
     */
    public function mostrarTipoInforme(): array {
        $query = "SHOW COLUMNS FROM servicio WHERE Field = 'ser_tipo_informe'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['Type'])) {
            preg_match_all("/'([^']+)'/", $row['Type'], $matches);
            return $matches[1] ?? [];
        }
        return [];
    }

    /**
     * Guarda el informe completo siguiendo la lógica de tu base de datos actual.
     * Crea los registros dependientes primero y luego los vincula en la tabla 'servicio'.
     */
    public function guardarInformeCompleto($datos, $rutasFotos) {
    $this->db->beginTransaction();
    try {
        // PASO 1: Crear la Ubicación y obtener su ID.
        $stmtUbicacion = $this->db->prepare("INSERT INTO ubicacion (ubi_sitio, ubi_ciudad, ubi_departamento, ubi_barrio, ubi_localidad, ubi_calle) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtUbicacion->execute([ $datos['ubi_sitio'], $datos['ubi_ciudad'], $datos['ubi_departamento'], $datos['ubi_barrio'], $datos['ubi_localidad'], $datos['ubi_calle'] ]);
        $ubicacionId = $this->db->lastInsertId();

        // PASO 2: Crear la Inspección General y obtener su ID.
        $stmtInspeccion = $this->db->prepare("INSERT INTO inspeccion_general (ig_goteos, ig_gabinete, ig_filtro, ig_drenaje, ig_serpentin, ig_refigerante, ig_vibracion, ig_tablero_electrico, ig_aislamiento_gabinete, ig_flujo_aire, ig_amperios, ig_voltaje, ig_temp_suministro, ig_temp_retorno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtInspeccion->execute([
            isset($datos['ig_goteras']) ? 1 : 0, isset($datos['ig_gabinete']) ? 1 : 0,
            isset($datos['ig_filtro']) ? 1 : 0, isset($datos['ig_drenaje']) ? 1 : 0,
            isset($datos['ig_serpentin']) ? 1 : 0, isset($datos['ig_refrigerante']) ? 1 : 0,
            isset($datos['ig_vibracion']) ? 1 : 0, isset($datos['ig_tablero_electrico']) ? 1 : 0,
            isset($datos['ig_aislamiento_gabinete']) ? 1 : 0, isset($datos['ig_flujo_aire']) ? 1 : 0,
            $datos['ig_amperios'], $datos['ig_voltaje'],
            $datos['ig_temp_suministro'], $datos['ig_temp_retorno']
        ]);
        $inspeccionId = $this->db->lastInsertId();
        
        // PASO 3: Obtener ID del técnico.
        $stmtTecnicoId = $this->db->prepare("SELECT id_tecnico FROM tecnico WHERE id_usuario = ?");
        $stmtTecnicoId->execute([$_SESSION['id_usuario']]);
        $tecnicoId = $stmtTecnicoId->fetchColumn();
        if (!$tecnicoId) { throw new Exception("El usuario actual no es un técnico registrado."); }

        // CORRECCIÓN DE HORA Y FECHA
        $fechaServicio = $datos['ser_fecha']; // <-- CORRECCIÓN AQUÍ: Usamos el nuevo nombre del campo.
        $horaEntradaCompleta = $fechaServicio . ' ' . $datos['ser_hora_entrada'];
        $horaSalidaCompleta = $fechaServicio . ' ' . $datos['ser_hora_salida'];

        // PASO 4: Crear el SERVICIO principal.
        $stmtServicio = $this->db->prepare("INSERT INTO servicio (id_cliente, id_tecnico, id_ubicacion, id_inspeccion_general, ser_tipo_servicio, ser_tipo_informe, ser_fecha, ser_hora_entrada, ser_hora_salida, ser_observaciones, ser_firma_tecnico, ser_firma_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtServicio->execute([
            $datos['id_cliente'], $tecnicoId, $ubicacionId, $inspeccionId,
            $datos['ser_tipo_servicio'], $datos['ser_tipo_informe'], $fechaServicio,
            $horaEntradaCompleta, $horaSalidaCompleta,
            $datos['ser_observaciones'], $datos['ser_firma_tecnico'], $datos['ser_firma_cliente']
        ]);
        $servicioId = $this->db->lastInsertId();

        // PASO 5: Crear la Revisión Mecánica.
        $stmtRevision = $this->db->prepare("INSERT INTO revision_mecanica (id_servicio, rm_ejes, rm_rodamientos, rm_chumaceras, rm_poleas, rm_correas, rm_rejillas, rm_pintura, rm_ductos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtRevision->execute([
            $servicioId, $datos['rm_ejes'], $datos['rm_rodamientos'], $datos['rm_chumaceras'], $datos['rm_poleas'],
            $datos['rm_correas'], $datos['rm_rejillas'], $datos['rm_pintura'], $datos['rm_ductos']
        ]);
        $revisionId = $this->db->lastInsertId();

        // PASO 6: ACTUALIZAR el servicio para añadir el ID de la revisión.
        $stmtUpdateServicio = $this->db->prepare("UPDATE servicio SET id_revision_mecanica = ? WHERE id_servicio = ?");
        $stmtUpdateServicio->execute([$revisionId, $servicioId]);

        // PASO 7: Guardar los equipos.
        if (!empty($datos['equipos']) && is_array($datos['equipos'])) {
            $stmtEquipo = $this->db->prepare("INSERT INTO equipo (equi_tipo_equipo, equi_marca, equi_modelo, equi_serie, equi_ubicacion, equi_cantidad) VALUES (?, ?, ?, ?, ?, 1)");
            $stmtVinculo = $this->db->prepare("INSERT INTO servicio_equipo (id_servicio, id_equipo) VALUES (?, ?)");
            foreach ($datos['equipos'] as $equipo) {
                $stmtEquipo->execute([ $equipo['equi_tipo_equipo'], $equipo['equi_marca'], $equipo['equi_modelo'], $equipo['equi_serie'], $equipo['equi_ubicacion'] ]);
                $equipoId = $this->db->lastInsertId();
                $stmtVinculo->execute([$servicioId, $equipoId]);
            }
        }
        
        $this->db->commit();
        return $servicioId;

    } catch (Exception $e) {
        $this->db->rollBack();
        error_log("Error al guardar informe: " . $e->getMessage());
        return false;
    }
}

    /**
     * Obtiene los datos completos para el PDF, adaptado a tu estructura de BD.
     */
    public function obtenerInformeCompletoPorId($id) {
        $resultado = [];
        // 1. Obtener el servicio principal
        $stmtInforme = $this->db->prepare("SELECT s.*, ub.ubi_sitio as cliente_direccion FROM servicio s LEFT JOIN ubicacion ub ON s.id_ubicacion = ub.id_ubicacion WHERE s.id_servicio = ?");
        $stmtInforme->execute([$id]);
        $resultado['informe'] = $stmtInforme->fetch(PDO::FETCH_ASSOC);
        if (!$resultado['informe']) return false;

        // 2. Obtener los datos relacionados usando los IDs del servicio
        $idCliente = $resultado['informe']['id_cliente'];
        $idTecnico = $resultado['informe']['id_tecnico'];
        $idInspeccion = $resultado['informe']['id_inspeccion_general'];
        $idRevision = $resultado['informe']['id_revision_mecanica'];

        $stmtCliente = $this->db->prepare("SELECT * FROM cliente WHERE id_cliente = ?");
        $stmtCliente->execute([$idCliente]);
        $resultado['cliente'] = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        $stmtTecnico = $this->db->prepare("SELECT u.* FROM usuario u JOIN tecnico t ON u.id_usuario = t.id_usuario WHERE t.id_tecnico = ?");
        $stmtTecnico->execute([$idTecnico]);
        $resultado['tecnico'] = $stmtTecnico->fetch(PDO::FETCH_ASSOC);

        $stmtEquipos = $this->db->prepare("SELECT e.* FROM equipo e JOIN servicio_equipo se ON e.id_equipo = se.id_equipo WHERE se.id_servicio = ?");
        $stmtEquipos->execute([$id]);
        $resultado['equipos'] = $stmtEquipos->fetchAll(PDO::FETCH_ASSOC);

        $stmtInspeccion = $this->db->prepare("SELECT * FROM inspeccion_general WHERE id_inspeccion_general = ?");
        $stmtInspeccion->execute([$idInspeccion]);
        $resultado['inspeccion'] = $stmtInspeccion->fetch(PDO::FETCH_ASSOC);
        
        $stmtRevision = $this->db->prepare("SELECT * FROM revision_mecanica WHERE id_revision_mecanica = ?");
        $stmtRevision->execute([$idRevision]);
        
        $revisionData = $stmtRevision->fetch(PDO::FETCH_ASSOC);
        if ($revisionData) {
            $resultado['informe'] = array_merge($resultado['informe'], $revisionData);
        }

        return $resultado;
    }
}