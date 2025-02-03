<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/models/GestorPedidos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/models/Pedido.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/models/LineaPedido.php');



class PedidosController
{
    public function insertar()
    {
        $carrito = $_SESSION['carrito'];
        $usuario = $_SESSION['dni'];
        $fecha = date('Y-m-d H:i:s');
        $total = 0;
        foreach ($carrito as $item) {
            $total += $item['cantidad'] * $item['precio'];
        }
        $pedido = new Pedido(0, $fecha, $total, 1, $usuario, 1);
        $con = conectar_db_pdo();
        $gestorPedidos = new GestorPedidos($con);
        $cod_pedido = $gestorPedidos->insertar($pedido);

        if ($cod_pedido) {
            foreach ($carrito as &$item) {
                $lineaPeido = new LineaPedido(
                    0,
                    $cod_pedido,
                    $item['id'],
                    $item['cantidad'],
                    $item['pvp'],
                    $item['descuento']
                );
                $gestorPedidos->insertarLineaPedido($lineaPeido);
            }
        }
    }

    public function ver_pedidos(){
        $dni = null;
        if(isset($_SESSION['dni'])){
            $dni = $_SESSION['dni'];
        }else{
            header('Location: ?action=mostrar_articulos');
        }
        $con = conectar_db_pdo();
        $gestorPedidos = new GestorPedidos($con);
        $pedidos = $gestorPedidos->getPedidosByUser($dni);
        require VIEWS_PATH . '/listaPedidosView.php';

    }

    public function info_pedido($idpedido){
        $con = conectar_db_pdo();
        $gestorPedidos = new GestorPedidos($con);
        $pedidos = $gestorPedidos->getlineaPedido($idpedido);
        require VIEWS_PATH . '/listaLineaPedidosView.php';
    }

}