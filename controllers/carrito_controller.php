<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');

include($_SERVER['DOCUMENT_ROOT'] . '/models/GestorCarrito.php');

class CarritoController
{

  public function add()
  {
    $id_producto = null;
    $cantidad = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
      $id_producto = $_POST['id_producto'];
      $cantidad = max(1, intval($_POST['cantidad'])); // Asegurar que la cantidad sea al menos 1
      $con = conectar_db_pdo();
      $gestorArticulos = new GestorArticulos($con);
      $data = $gestorArticulos->buscarCodigo($id_producto);
      if (count($data) > 0) {
        $producto = $data[0];
        // Crear carrito y agregarlo si no existe
        if (!isset($_SESSION['carrito'])) {
          $_SESSION['carrito'] = [];
        }
        $encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) {
          if ($item['id'] === $producto->getCodigo()) {
            $item['cantidad'] += $cantidad;
            $encontrado = true;
            break;
          }
        }

        // Si no está en el carrito, agregarlo
        if (!$encontrado) {
          $_SESSION['carrito'][] = [
            'id' => $producto->getCodigo(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'descuento' => $producto->getDescuento(),
            'cantidad' => $cantidad
          ];
        }
      }
    }
    header('Location: ?action=mostrar_articulos');
  }
}
?>