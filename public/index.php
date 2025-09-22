<?php
// public/index.php

// Composer autoload (PHPMailer, etc.)
require_once __DIR__ . '/../vendor/autoload.php';

// Configuración general
require_once __DIR__ . '/../config/config.php';

// Mostrar errores en desarrollo (desactiva en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Modelos
require_once __DIR__ . '/../app/models/UsuarioModel.php';
require_once __DIR__ . '/../app/models/Tecnico.php';
require_once __DIR__ . '/../app/models/DashboardModel.php';
require_once __DIR__ . '/../app/models/ServicioModel.php';
require_once __DIR__ . '/../app/models/EmpresaModel.php';
require_once __DIR__ . '/../app/models/Equipo.php';
require_once __DIR__ . '/../app/models/Cliente.php';
require_once __DIR__ . '/../app/models/VisualizacionModel.php';

// Controladores
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/ServicioController.php';
require_once __DIR__ . '/../app/controllers/EmpresaController.php';
require_once __DIR__ . '/../app/controllers/EquipoController.php';
require_once __DIR__ . '/../app/controllers/ClienteController.php';
require_once __DIR__ . '/../app/controllers/VisualizacionController.php';

// Usos de namespaces (corrigiendo mayúsculas/minúsculas)
use App\Controllers\UsuarioController;
use App\Controllers\DashboardController;
use App\Controllers\ServicioController;
use App\Controllers\InformeController;
use App\Controllers\EmpresaController;
use App\Controllers\EquipoController;
use App\Controllers\ClienteController;
use App\Controllers\VisualizacionController;

// Enrutador básico
$action = $_GET['action'] ?? 'login';

// Instancias de controladores
$usuarioController = new UsuarioController($db);
$dashboardController = new DashboardController($db);
$servicioController = new ServicioController($db);
$empresaController = new EmpresaController($db);
$equipoController = new EquipoController($db);
$clienteController = new ClienteController($db);
$visualizacionController = new VisualizacionController($db);

// Switch de acciones
switch ($action) {
    case 'login': $usuarioController->mostrarLogin(); break;
    case 'iniciar_sesion': $usuarioController->iniciarSesion(); break;
    case 'cerrar_sesion': $usuarioController->cerrarSesion(); break;

    case 'ircreacion': $informeController->ircreacion(); break;

    // Password reset
    case 'solicitar_reset': $usuarioController->mostrarFormularioSolicitud(); break;
    case 'procesar_solicitud': $usuarioController->procesarSolicitud(); break;
    case 'mostrar_formulario_reset': $usuarioController->mostrarFormularioReset(); break;
    case 'procesar_reset': $usuarioController->procesarReset(); break;

    // Dashboards
    case 'dashboard_admin': $dashboardController->showAdminDashboard(); break;
    case 'dashboard_tecnico': $dashboardController->showTecnicoDashboard(); break;

    // Usuarios
    case 'gestionar_usuarios': $usuarioController->gestionarUsuarios(); break;
    case 'mostrar_crear_usuario': $usuarioController->mostrarFormularioCrear(); break;
    case 'crear_usuario': $usuarioController->crearUsuario(); break;
    case 'mostrar_editar_usuario': $usuarioController->mostrarFormularioEditar(); break;
    case 'editar_usuario': $usuarioController->editarUsuario(); break;
    case 'eliminar_usuario': $usuarioController->eliminarUsuario(); break;
    case 'irsoporte': $usuarioController->irsoporte(); break;

    // Clientes
    case 'gestionar_clientes': $clienteController->gestionarClientes(); break;
    case 'mostrar_crear_cliente': $clienteController->mostrarFormularioCrear(); break;
    case 'crear_cliente': $clienteController->crearCliente(); break;
    case 'mostrar_editar_cliente': $clienteController->mostrarFormularioEditar(); break;
    case 'editar_cliente': $clienteController->editarCliente(); break;
    case 'eliminar_cliente': $clienteController->eliminarCliente(); break;

    // Informes
    case 'crear_informe': $servicioController->mostrarFormularioCrear(); break;
    case 'guardar_informe': $servicioController->guardarInforme(); break;
    case 'gestionar_informes':
            $servicioController->gestionarInformes();
            break;

        case 'graficas_informes':
            $servicioController->graficasInformes();
        break;
    case 'generar_pdf': $servicioController->generarPdf(); break;

    // Visualización
    case 'ver_historial': $visualizacionController->mostrarHistorial(); break;

    // Empresas
    case 'gestionar_empresas': $empresaController->gestionarEmpresas(); break;
    case 'mostrar_crear_empresa': $empresaController->mostrarFormularioCrear(); break;
    case 'crear_empresa': $empresaController->crearEmpresa(); break;
    case 'mostrar_editar_empresa': $empresaController->mostrarFormularioEditar(); break;
    case 'editar_empresa': $empresaController->editarEmpresa(); break;
    case 'eliminar_empresa': $empresaController->eliminarEmpresa(); break;

    default:
        header('Location: ' . BASE_URL . '?action=login');
        exit();
}
