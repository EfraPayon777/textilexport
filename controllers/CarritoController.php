<?php
require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Venta.php';
require_once __DIR__ . '/../vendor/autoload.php';
class CarritoController {
    private $carrito;
    private $producto;

    public function __construct() {
        $this->carrito = new Carrito();
        $this->producto = new Producto();
    }

    public function agregarAlCarrito() {
        $this->verificarAutenticacionCliente();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'], $_POST['cantidad'])) {
            $producto_id = $_POST['producto_id'];
            $cantidad = $_POST['cantidad'];
            $cliente_id = $_SESSION['cliente']['id'];
    
            // Obtener carrito activo
            $carrito = $this->carrito->obtenerCarritoActivo($cliente_id);
    
            if ($carrito) {
                // Agregar producto al carrito
                if ($this->carrito->agregarProducto($carrito['id'], $producto_id, $cantidad)) {
                    $_SESSION['exito'] = "Producto añadido al carrito.";
                } else {
                    $_SESSION['error'] = "No se pudo añadir el producto al carrito.";
                }
            } else {
                $_SESSION['error'] = "No se encontró el carrito.";
            }
        }
    
        
        header("Location: ?action=productos");
        exit();
    }

    public function verCarrito() {
        $this->verificarAutenticacionCliente();
        
        $carrito = $this->carrito->obtenerCarritoActivo($_SESSION['cliente']['id']);
        $productos = $carrito ? $this->carrito->obtenerDetalles($carrito['id']) : [];
        
        require_once __DIR__ . '/../views/carrito/ver.php';
    }

    public function procesarCompra() {
        $this->verificarAutenticacionCliente();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $carrito = $this->carrito->obtenerCarritoActivo($_SESSION['cliente']['id']);
            if (!$carrito) {
                $_SESSION['error'] = "No se encontró un carrito activo.";
                header("Location: ?action=ver-carrito");
                exit();
            }
    
            $detalles = $this->carrito->obtenerDetalles($carrito['id']);
            if (empty($detalles)) {
                $_SESSION['error'] = "El carrito está vacío.";
                header("Location: ?action=ver-carrito");
                exit();
            }
            
            // Crear venta
            $ventaModel = new Venta();
            $venta_id = $ventaModel->crearVenta($_SESSION['cliente']['id'], $detalles);
            if (!$venta_id) {
                $_SESSION['error'] = "Hubo un problema al procesar la venta.";
                header("Location: ?action=ver-carrito");
                exit();
            }
    
           
            $venta = $ventaModel->obtenerVentaPorId($venta_id);
    
            // Generar PDF
            $this->generarPDF($venta_id, $detalles, [
                'nombre' => $_SESSION['cliente']['nombre'],
                'email' => $_SESSION['cliente']['email'],
                'fecha' => $venta['fecha'] 
            ]);
    
            // Vaciar carrito
            $this->vaciarCarrito();
            
            $_SESSION['exito'] = "Compra realizada exitosamente. Se ha generado tu comprobante.";
            header("Location: ?action=productos");
            exit();
        }
    }

    public function generarPDF($pedidoId, $productos, $cliente = null) {
        while (ob_get_level()) {
            ob_end_clean();
        }
        try {
            require_once __DIR__ . '/../vendor/autoload.php';
            if (empty($productos)) {
                throw new Exception('Datos incompletos para generar el PDF');
            }
    
           
            if (!$cliente) {
                if (!isset($_SESSION['cliente'])) {
                    throw new Exception('Cliente no autenticado');
                }
                $cliente = $_SESSION['cliente'];
            }
    
            //Configuracion del PDF
            $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetMargins(15, 25, 15);
            $pdf->SetAutoPageBreak(true, 25);
            $pdf->AddPage();
    
            $html = '
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 10px;">TextileXport</h1>
                <p style="color: #7f8c8d;">Comprobante de Compra</p>
            </div>';
            $fechaFormateada = isset($cliente['fecha']) ? (new DateTime($cliente['fecha']))->format('d/m/Y H:i') : 'Fecha no disponible';
            // Datos cliente 
            $html .= '
            <div style="margin-bottom: 20px;">
                <p>
                    <strong>Cliente:</strong> ' . htmlspecialchars($cliente['nombre'] ?? '') . '<br>
                    <strong>Email:</strong> ' . htmlspecialchars($cliente['email'] ?? '') . '<br>
                    <strong>Pedido:</strong> TX-' . $pedidoId . '<br>
                    <strong>Fecha:</strong> ' . $fechaFormateada . '
                </p>
            </div>';
    
            // Tabla de productos
            $html .= '
            <table border="0" cellpadding="5" width="100%">
                <tr style="background-color: #2c3e50; color: white;">
                    <th width="60%">Producto</th>
                    <th width="15%" style="text-align: right;">Precio</th>
                    <th width="10%" style="text-align: center;">Cantidad</th>
                    <th width="15%" style="text-align: right;">Total</th>
                </tr>';
    
            $total = 0;
            foreach ($productos as $p) {
                $subtotal = ($p['precio'] ?? 0) * ($p['cantidad'] ?? 0);
                $total += $subtotal;
    
                $html .= '
                <tr>
                    <td>' . htmlspecialchars($p['nombre'] ?? '') . '</td>
                    <td style="text-align: right;">$' . number_format($p['precio'] ?? 0, 2) . '</td>
                    <td style="text-align: center;">' . ($p['cantidad'] ?? 0) . '</td>
                    <td style="text-align: right;">$' . number_format($subtotal, 2) . '</td>
                </tr>';
            }
    
            // Total
            $html .= '
                <tr style="background-color: #f8f9fa;">
                    <td colspan="3" style="text-align: right; padding-right: 10px;"><strong>Total:</strong></td>
                    <td style="text-align: right;"><strong>$' . number_format($total, 2) . '</strong></td>
                </tr>
            </table>';
    
            // Mensaje final
            $html .= '
            <div style="margin-top: 30px; color: #7f8c8d; font-size: 10px; text-align: center;">
                <p>Gracias por su compra en TextileXport</p>
            </div>';
    
            // Generar PDF
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output("comprobante_tx_$pedidoId.pdf", 'I');
            exit;
    
        } catch (Exception $e) {
            error_log('Error PDF: ' . $e->getMessage());
            if (!headers_sent()) {
                $_SESSION['error'] = 'Error al generar el comprobante';
                header('Location: ?action=ver-carrito');
                exit;
            }
        }
    }

    private function verificarAutenticacionCliente() {

        // Iniciar sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['cliente'])) {
            $_SESSION['error'] = "Debes iniciar sesión para acceder al carrito";
            header("Location: ?action=login-cliente");
            exit();
        }
    
    }
    public function eliminarProducto() {
        $this->verificarAutenticacionCliente();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
            $cliente_id = $_SESSION['cliente']['id'];
            $producto_id = $_POST['producto_id'];
    
            // Obtener carrito activo
            $carrito = $this->carrito->obtenerCarritoActivo($cliente_id);
    
            if ($carrito) {
                // Eliminar producto
                if ($this->carrito->eliminarProducto($carrito['id'], $producto_id)) {
                    $_SESSION['exito'] = "Producto eliminado correctamente";
                } else {
                    $_SESSION['error'] = "Error al eliminar el producto";
                }
            } else {
                $_SESSION['error'] = "No se encontró el carrito";
            }
        }
    
       
        header("Location: ?action=ver-carrito");
        exit();
    }


    public function vaciarCarrito() {
        $this->verificarAutenticacionCliente();
        $carrito = $this->carrito->obtenerCarritoActivo($_SESSION['cliente']['id']);

        if ($carrito) {
            $this->carrito->vaciarCarrito($carrito['id']);
            $_SESSION['exito'] = "Carrito vaciado exitosamente";
        } else {
            $_SESSION['error'] = "No se encontró el carrito";
        }

        header("Location: ?action=ver-carrito");
        exit();
    }
}
?>
