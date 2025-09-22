<?php
// ===== app/controllers/ServicioController.php (VERSIÓN FINAL) =====

namespace App\Controllers;

use App\Models\ServicioModel;
use App\Models\Cliente;
use App\Models\Ubicacion;
use App\Models\EmpresaModel;
use Mpdf\Mpdf;
use PDO;

require_once __DIR__ . '/../models/ServicioModel.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Ubicacion.php';
require_once __DIR__ . '/../models/EmpresaModel.php';

class ServicioController {
    
    private $servicioModel;
    private $clienteModel;
    private $ubicacionModel;
    private $empresaModel;

    public function __construct(PDO $db) {
        $this->servicioModel = new ServicioModel($db);
        $this->clienteModel = new Cliente($db);
        $this->ubicacionModel = new Ubicacion($db);
        $this->empresaModel = new EmpresaModel($db);
    }

    public function mostrarFormularioCrear() {
        if (!isset($_SESSION['id_usuario'])) {
            header('Location: /softGenn/public/index.php?action=login');
            exit();
        }

        $clientes = $this->clienteModel->getClientes();
        $departamentos = $this->ubicacionModel->getDepartamentos();
        $tipos_servicio = $this->servicioModel->mostrarTipoServicio();
        $tipos_informe = $this->servicioModel->mostrarTipoInforme();
        $empresas = $this->empresaModel->obtenerEmpresa();

        require_once '../app/views/informes/crear_informe.php';
    }

    public function gestionarInformes() {
        // Verificar si el usuario ha iniciado sesión y tiene el rol correcto (ej. administrador)
        if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
            header('Location: /softGenn/public/index.php?action=login');
            exit();
        }

        $busqueda = $_GET['busqueda'] ?? '';
        $pagina = $_GET['pagina'] ?? 1;

        // Obtener los informes desde el modelo
        $informes = $this->servicioModel->obtenerInformesConPaginacion($busqueda, $pagina, 10);
        $totalPaginas = $this->servicioModel->contarInformes($busqueda, 10);
        
        require_once '../app/views/informes/gestion_informes.php';
    }

    public function generarPdf() {
        $id = $_GET['id'] ?? null;
        if (!$id) { die("ID de informe no especificado."); }

        $datosCompletos = $this->servicioModel->obtenerInformeCompletoPorId($id);
        if (!$datosCompletos) { die("Informe no encontrado."); }

        extract($datosCompletos); 

        ob_start();
        require_once '../app/views/informes/reporte_pdf.php';
        $html = ob_get_clean();

        try {
    $mpdf = new \Mpdf\Mpdf([
        'mode'   => 'utf-8',
        'format' => 'A4',
        // IMPORTANTE en Windows/XAMPP → dale una carpeta temporal propia
        'tempDir' => __DIR__ . '/../../tmp'
    ]);

    $mpdf->WriteHTML($html);
    $mpdf->Output('Informe_Servicio_' . $id . '.pdf', 'I');
    exit();
} catch (\Mpdf\MpdfException $e) {
    die("Error al generar el PDF: " . $e->getMessage());
}
    }
    
    private function guardarFirma($dataBase64, $prefix, $directorio) {
        if (empty($dataBase64) || !str_contains($dataBase64, 'base64')) return null;
        list(, $data) = explode(',', $dataBase64);
        $data = base64_decode($data);
        $nombreArchivo = $prefix . uniqid() . '.png';
        if (!is_dir($directorio)) { mkdir($directorio, 0777, true); }
        file_put_contents($directorio . $nombreArchivo, $data);
        return str_replace('../public/', '', $directorio) . $nombreArchivo;
    }

    private function guardarFotos($files, $descripciones, $directorio) {
        $rutas = [];
        if (!is_dir($directorio)) { mkdir($directorio, 0777, true); }
        foreach ($files['tmp_name'] as $key => $tmpName) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $nombreArchivo = 'foto_' . uniqid() . '_' . basename($files['name'][$key]);
                if (move_uploaded_file($tmpName, $directorio . $nombreArchivo)) {
                    $rutas[] = [
                        'ruta' => str_replace('../public/', '', $directorio) . $nombreArchivo,
                        'descripcion' => $descripciones[$key] ?? ''
                    ];
                }
            }
        }
        return $rutas;
    }

 public function graficasInformes()
{
    $tipos = $this->servicioModel->obtenerConteoPorTipoServicio();
    $estados = $this->servicioModel->obtenerConteoPorEstado();

    header('Content-Type: application/json');
    echo json_encode([
        'tipos' => $tipos,
        'estados' => $estados
    ]);
}

}
