<?php
// public/index.php

use App\Models\EmpresaModel;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión al principio de todo
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- 1. Cargar Archivos Esenciales ---
// El orden es importante: primero la configuración, luego los modelos, luego los controladores.
require_once __DIR__. '/../config/config.php'; 

// Modelos
require_once __DIR__ .'/../app/models/UsuarioModel.php';
require_once __DIR__ .'/../app/models/Tecnico.php'; // Modelo para la gestión de técnicos
require_once __DIR__ .'/../app/models/DashboardModel.php';
require_once __DIR__ .'/../app/models/ServicioModel.php';
require_once __DIR__ .'/../app/models/Informe.php'; // Aseguramos que el modelo de servicio esté cargado
require_once __DIR__. '/../app/models/EmpresaModel.php';
require_once __DIR__. '/../app/models/equipo.php';
require_once __DIR__. '/../app/models/Cliente.php';
require_once __DIR__. '/../app/models/visualizacionmodel.php';



// Controladores
require_once __DIR__. '/../app/controllers/UsuarioController.php';
require_once __DIR__. '/../app/controllers/DashboardController.php' ;
require_once __DIR__. '/../app/controllers/ServicioController.php';
require_once __DIR__. '/../app/controllers/InformeController.php';
require_once __DIR__. '/../app/controllers/empresacontroller.php';
require_once __DIR__. '/../app/controllers/equipocontroller.php';
require_once __DIR__. '/../app/controllers/ClienteController.php';
require_once __DIR__. '/../app/controllers/visualizacioncontroller.php'; // <-- AÑADE ESTA LÍNEA
require_once __DIR__. '/../app/controllers/visualizacioncontroller.php';

use App\Controllers\UsuarioController;
use App\Controllers\DashboardController;
use App\controllers\ServicioController;
use app\controllers\InformeController;
use App\Controllers\EmpresaController;
use App\Controllers\equipocontroller;
use app\Controllers\ClienteController;
use app\Controllers\visualizacioncontroller;

// --- 2. Enrutador Básico ---
// La acción por defecto, si no se especifica ninguna, será mostrar el login.
$action = $_GET['action'] ?? 'login';

// Instanciamos los controladores que vamos a necesitar.
$usuarioController = new UsuarioController($db);
$dashboardController = new DashboardController($db);
$servicioController = new ServicioController($db);
$EmpresaController = new EmpresaController($db);
$equipocontroller = new equipocontroller($db);
$clienteController = new clienteController($db);
$visualizacioncontroller = new visualizacioncontroller($db);


// --- 3. Decidir qué acción ejecutar ---
switch ($action) {
    // --- Rutas de Autenticación ---
    case 'login':
        $usuarioController->mostrarLogin();
        break;
    case 'iniciar_sesion':
        $usuarioController->iniciarSesion();
        break;
    case 'cerrar_sesion':
        $usuarioController->cerrarSesion();
        break;

    case 'ircreacion':
        $informeController->ircreacion();
        break;

    //Password reset
        case 'solicitar_reset': 
        $usuarioController->mostrarFormularioSolicitud(); 
        break;
    case 'procesar_solicitud': 
        $usuarioController->procesarSolicitud(); 
        break;
    case 'mostrar_formulario_reset': 
        $usuarioController->mostrarFormularioReset(); 
        break;
    case 'procesar_reset': 
        $usuarioController->procesarReset(); 
        break;
    

    // --- Rutas de Dashboards ---
    case 'dashboard_admin':
        $dashboardController->showAdminDashboard();
        break;
    case 'dashboard_tecnico':
        $dashboardController->showTecnicoDashboard();
        break;

    // --- Rutas de Gestión de Usuarios (CRUD) ---
    case 'gestionar_usuarios':
        $usuarioController->gestionarUsuarios();
        break;
    case 'mostrar_crear_usuario':
        $usuarioController->mostrarFormularioCrear();
        break;
    case 'crear_usuario':
        $usuarioController->crearUsuario();
        break;
    case 'mostrar_editar_usuario':
        $usuarioController->mostrarFormularioEditar();
        break;
    case 'editar_usuario':
        $usuarioController->editarUsuario();
        break;
    case 'eliminar_usuario':
        $usuarioController->eliminarUsuario();
        break;

    case 'soporte':
        $usuarioController->soporte();
        break;

    // --- Rutas de Gestión de Informes ---
    //case 'gestionar_informes':
        //$servicioController->gestionarInformes();
       // break;

    // --- Rutas de Gestión de Clientes (CRUD) ---
    case 'gestionar_clientes': 
        $clienteController->gestionarClientes(); 
        break;
    case 'mostrar_crear_cliente': 
        $clienteController->mostrarFormularioCrear(); 
        break;
    case 'crear_cliente': 
        $clienteController->crearCliente(); 
        break;
    case 'mostrar_editar_cliente': 
        $clienteController->mostrarFormularioEditar(); 
        break;
    case 'editar_cliente': 
        $clienteController->editarCliente(); 
        break;
    case 'eliminar_cliente': 
        $clienteController->eliminarCliente(); 
        break;


    case 'crear_informe':
        $servicioController->mostrarFormularioCrear();
        break;

    case 'guardar_informe':
        // Esta acción es llamada por el <form action="...">
        $servicioController->guardarInforme();
        break;

    case 'gestionar_informes':
        $informeController->gestionarInformes();
        break;

    case 'generar_pdf':
        // Esta acción se llama después de guardar exitosamente
        $servicioController->generarPdf();
        break;

   /* case 'eliminar_informe':
        $visualizacioncontroller->eliminarinforme();
        break; */

    /*case 'mostrar_visualizacion':
        $visualizacioncontroller->mostrarvisualizacion();
        break;*/

    case 'ver_historial':
        $visualizacioncontroller->mostrarHistorial();
        break;

    default:
        // Si la acción no coincide con ninguna, redirigir al login por seguridad.
        header('Location: /softGenn/public/index.php?action=login');
        exit();
}
