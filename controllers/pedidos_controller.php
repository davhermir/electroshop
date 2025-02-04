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

    public function gestion_pedidos($pagina, $pags, $ini,$id){
        $con = conectar_db_pdo();
        $gestorPedidos = new GestorPedidos($con);
        $num_total_registros = $gestorPedidos->countTotalPedidos($id);
        $total_paginas = ceil($num_total_registros / $pags);
        $pedidos = [];
        if($id!=null){
        $pedidos = $gestorPedidos->getPedidoById($id);
        }else{
        $pedidos = $gestorPedidos->getAllPedidos();
        }
        require VIEWS_PATH . '/gestionPedidosView.php';
    }

    public function info_pedido($idpedido){
        $con = conectar_db_pdo();
        $gestorPedidos = new GestorPedidos($con);
        $pedidos = $gestorPedidos->getlineaPedido($idpedido);
        require VIEWS_PATH . '/listaLineaPedidosView.php';
    }

    public function editar_pedido($idPedido)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorPedidos($con);
    $data = $gestor->getPedidoById($idPedido);
    if (count($data) > 0) {
      $pedido = $data[0];
    } else {
      header('Location: action=mostrar_articulos');
    }
    require VIEWS_PATH . '/edicionPedidoView.php';
  }

  public function check_editar_pedido(){
    if (isset($_POST['id'])) {
        $con = conectar_db_pdo();
        $gestor = new GestorPedidos($con);
          $id=$_POST['id'];
          $estado = $_POST['estado'];
          $activo = $_POST['activo'];
          $gestor->modificar($id,$estado,$activo);
      }
  }

}