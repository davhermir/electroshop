<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/models/GestorCarrito.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/models/GestorUsuarios.php');

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
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
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
            'precio' => $producto->calcularPrecioOferta(),
            'pvp' => $producto->getPrecio(),
            'descuento' => $producto->getDescuento(),
            'cantidad' => $cantidad,
            'img' => $producto->getImagen()
          ];
        }
      }
    }
    header('Location: ?action=mostrar_articulos');
  }

  public function restar($id)
  {
    foreach ($_SESSION['carrito'] as $index => &$item) {
      if ($item['id'] === $id) {
        $cantidad = $item['cantidad'] - 1;
        if ($cantidad == 0) {
          if (isset($_SESSION['carrito'][$index])) {
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
          }
        } else {
          $item['cantidad'] -= 1;
        }
        break;
      }
    }
    header('Location: ?action=mostrar_carrito');
  }

  public function sumar($id)
  {
    foreach ($_SESSION['carrito'] as &$item) {
      if ($item['id'] === $id) {
        $item['cantidad'] += 1;
        break;
      }
    }
    header('Location: ?action=mostrar_carrito');
  }

  public function mostrar_carrito()
  {
    $user = null;
    if(isset($_SESSION['dni'])) {
      $con = conectar_db_pdo();
      $gestorUsuarios = new GestorUsuarios($con);
      $user = $gestorUsuarios->buscarDni($_SESSION['dni'])[0];
    }
    $carrito = null;
    if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
      $carrito = $_SESSION['carrito'];
      require VIEWS_PATH . '/mostrarCarritoView.php';
    } else {
      header('Location: ?action=mostrar_articulos');
    }
  }

  public function eliminar_carrito()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
      $index = $_POST['index'];
      if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
      }
    }
    header('Location: ?action=mostrar_carrito');
  }
}
?>