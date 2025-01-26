<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/Categoria.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/GestorCategorias.php');

//include 'config/seguridad.php';

class CategoriasController
{

  public function listarCategoriasNav()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $categorias = $gestor->getCategorias();
    $menu = $this->orderCategorias($categorias);
    require VIEWS_PATH . '/nav.php';
  }

  public function getCategorias(){
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $categorias = $gestor->getCategorias();
    $menu = $this->orderCategorias($categorias);
    require VIEWS_PATH .'/gestionCategoriasView.php';
  }

public function orderCategorias($categorias){
  $menu=[];
  foreach ($categorias as $item) {
    if ($item->getCodpadre() === null) {
      $menu[$item->getCodigo()] = [
        'categoria' => $item,
        'hijas' => []
      ];
    }
  }
  foreach ($categorias as $item) {
    if ($item->getCodpadre() !== null) {
      $menu[$item->getCodpadre()]['hijas'][] = $item;
    }
  }
  return $menu;
}
}
?>