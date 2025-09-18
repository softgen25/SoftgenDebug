<?php
// app/controllers/ClienteController.php
namespace App\Controllers;
require_once __DIR__ . '/../models/Cliente.php';
//Cambios hechos por Hi-Im-Harcs
use app\models\Cliente;

use PDO;

class ClienteController {

    public $db;
    private $clienteModel;

    public function __construct(PDO $db) {
        // Asumimos que ClienteModel.php ya está cargado en index.php
        $this->clienteModel = new Cliente($db);
    }
    /**
     * Muestra la lista de clientes con paginación y búsqueda.
     */
    public function gestionarClientes() {
        $this->verificarAdmin();

        $pagina = $_GET['pagina'] ?? 1;
        $busqueda = $_GET['busqueda'] ?? '';
        $porPagina = 15; // Clientes por página

        $clientes = $this->clienteModel->obtenerTodosPaginado($pagina, $porPagina, $busqueda);
        $totalClientes = $this->clienteModel->contarTodos($busqueda);
        $totalPaginas = ceil($totalClientes / $porPagina);

        // Cargar la vista y pasarle los datos
        require_once '../app/views/cliente/gestion_clientes.php';
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function mostrarFormularioCrear() {
        $this->verificarAdmin();
        require_once '../app/views/cliente/crear_cliente.php';
    }

    /**
     * Procesa los datos del formulario de creación.
     */
    //Creacion cliente verifica correo
    public function crearCliente() {
        $this->verificarAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST; // Recolectamos todos los datos del formulario

            // 🔹 Validar si el correo ya existe
            if ($this->clienteModel->existeCorreoCliente($datos['contacto_correo'])) {
                // Redirigimos con un error
                header('Location: /softGenn/public/index.php?action=mostrar_crear_cliente&status=correo_existente_cliente');
                exit();
            }

            // 🔹 Si no existe, lo creamos

            $this->clienteModel->crearCliente($datos);
            header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=creado_cliente');
            exit();
        }
    }

    /**
     * Muestra el formulario para editar un cliente existente.
     */
    public function mostrarFormularioEditar() {
        $this->verificarAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) { die('ID de cliente no especificado.'); }

        $cliente = $this->clienteModel->obtenerPorId($id);
        if (!$cliente) { die('Cliente no encontrado.'); }
        
        require_once '../app/views/cliente/editar_cliente.php';
    }

    /**
     * Procesa los datos del formulario de edición.
     */
    public function editarCliente() {
        $this->verificarAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_cliente'];
            $datos = $_POST;
            $exito = $this->clienteModel->actualizar($id, $datos);

            if ($exito) {
                header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=editado');
            } else {
                header('Location: /softGenn/public/index.php?action=mostrar_editar_cliente&id=' . $id . '&error=1');
            }
            exit();
        }
    }

    /**
     * Procesa la eliminación de un cliente.
     */
    public function eliminarCliente() {
    $this->verificarAdmin();
    $id = $_GET['id'] ?? null;

    if ($id) {
        try {
            $exito = $this->clienteModel->eliminar($id);
            if ($exito) {
                header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=cliente_eliminado');
            } else {
                // Caso raro: no eliminó pero tampoco lanzó excepción
                header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=error');
            }
        } catch (\PDOException $e) {
            // Verificamos si es error de clave foránea (1451)
            if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1451) {
                header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=eliminar_fallido');
            } else {
                // Otro error inesperado
                header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=error');
            }
        }
    } else {
        header('Location: /softGenn/public/index.php?action=gestionar_clientes&status=error');
    }
    exit();
    }

    /**
     * Función de ayuda para verificar si el usuario es administrador.
     */
    private function verificarAdmin() {
        if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
            header('Location: /softGenn/public/index.php?action=login&error=' . urlencode('Acceso no autorizado.'));
            exit();
        }
    }
}

