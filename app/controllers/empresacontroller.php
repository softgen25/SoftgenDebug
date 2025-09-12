<?php
namespace App\Controllers;

// Importamos el modelo y la clase PDO para usarlos en este archivo.
use App\Models\EmpresaModel;
use PDO;

/**
 * Controlador para gestionar las interacciones relacionadas con las empresas.
 */
class EmpresaController {
    
    /**
     * @var EmpresaModel Instancia del modelo de empresa.
     */
    private $empresaModel;

    /**
     * Constructor del controlador.
     * Se encarga de crear una instancia del modelo.
     * * @param PDO $db Conexión a la base de datos.
     */
    public function __construct(PDO $db) {
        // Creamos una nueva instancia de EmpresaModel, pasándole la conexión a la BD.
        $this->empresaModel = new EmpresaModel($db);
    }

    /**
     * Acción para listar todas las empresas.
     * Obtiene los datos del modelo y los pasa a una vista para ser mostrados.
     */
    public function listar() {
        try {
            // 1. Obtener todas las empresas llamando al método del modelo.
            $empresas = $this->empresaModel->obtenerEmpresa();

            // 2. Cargar la vista.
            // La vista se encargará de renderizar los datos en HTML.
            // La variable $empresas estará disponible dentro del archivo de la vista.
            // En un framework real, esto se manejaría con un motor de plantillas (ej. Twig).
            // Para este ejemplo, simplemente incluimos el archivo PHP.
            require_once __DIR__ . '/../Views/empresas/lista.php';

        } catch (\Exception $e) {
            // Manejo básico de errores
            error_log($e->getMessage());
            echo "<h1>Error al cargar los datos de las empresas.</h1>";
        }
    }
    public function gestionarEmpresas() {
        $this->verificarAdmin();

        $pagina = $_GET['pagina'] ?? 1;
        $busqueda = $_GET['busqueda'] ?? '';
        $porPagina = 15;

        $empresas = $this->empresaModel->obtenerTodasPaginadoEmpresa($pagina, $porPagina, $busqueda);
        $totalEmpresas = $this->empresaModel->contarTodasEmpresa($busqueda);
        $totalPaginas = ceil($totalEmpresas / $porPagina);

        require_once '../app/views/empresa/gestion_empresa.php';
    }

    /**
     * Muestra el formulario para crear una nueva empresa.
     */
    public function mostrarFormularioCrear() {
        $this->verificarAdmin();
        require_once '../app/views/empresa/crear_empresa.php';
    }

    /**
     * Procesa los datos del formulario de creación.
     */
    public function crearEmpresa() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST; // Recolectamos todos los datos del formulario

            // 🔹 Validar si el correo ya existe
            if ($this->empresaModel->existeCorreoEmpresa($datos['emp_correo'])) {
                // Redirigimos con un error
                header('Location: /softGenn/public/index.php?action=mostrar_crear_empresa&status=correo_existente_empresa');
                exit();
            }

            // 🔹 Si no existe, lo creamos
            $this->empresaModel->crearEmpresa($datos);
            header('Location: /softGenn/public/index.php?action=gestionar_empresas&status=creado');
            exit();
        }
    }

    /**
     * Muestra el formulario para editar una empresa existente.
     */
    public function mostrarFormularioEditar() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) { die('ID de empresa no especificado.'); }

        $empresa = $this->empresaModel->obtenerPorId($id);
        if (!$empresa) { die('Empresa no encontrada.'); }
        
        require_once '../app/views/empresa/editar_empresa.php';
    }

    /**
     * Procesa los datos del formulario de edición.
     */
    public function editarEmpresa() {
        $this->verificarAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_empresa'];

            // CORRECCIÓN DE SEGURIDAD: Crear un array con solo los datos esperados.
            $datos = [
                'emp_razon_social' => $_POST['emp_razon_social'] ?? null,
                'emp_nit' => $_POST['emp_nit'] ?? null,
                'emp_correo' => $_POST['emp_correo'] ?? null,
                'emp_telefono' => $_POST['emp_telefono'] ?? null
            ];

            $exito = $this->empresaModel->actualizar($id, $datos);

            if ($exito) {
                header('Location: /softGenn/public/index.php?action=gestionar_empresas&status=editado');
            } else {
                header('Location: /softGenn/public/index.php?action=mostrar_editar_empresa&id=' . $id . '&error=1');
            }
            exit();
        }
    }

    /**
     * Procesa la eliminación de una empresa.
     */
    public function eliminarEmpresa() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $exito = $this->empresaModel->eliminar($id);
            if ($exito) {
                header('Location: /softGenn/public/index.php?action=gestionar_empresas&status=eliminado');
            } else {
                header('Location: /softGenn/public/index.php?action=gestionar_empresas&error=eliminar_fallido');
            }
        } else {
            header('Location: /softGenn/public/index.php?action=gestionar_empresas');
        }
        exit();
    }
    
    private function verificarAdmin() {
        // Asegurarse de que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
            header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso no autorizado.'));
            exit();
        }
    }
}