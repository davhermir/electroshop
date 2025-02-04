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

  public function getCategorias()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $categorias = $gestor->getCategorias();
    return $categorias;
  }

  public function getCategoriasArticulos()
  {
    $categorias = $this->getCategorias();
    $menu = $this->getCategoriasHijas($categorias);
    return $menu;
  }

  public function getCategoriasView($error)
  {
    $error_borrado = null;
    $cat_padre = null;
    switch ($error) {
      case 'error_borrado':
        $error_borrado = true;
        break;
      case 'cat_padre':
        $cat_padre = true;
        break;
    }
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $categorias = $gestor->getCategoriasAdmin();
    $totalCategorias = count($categorias);
    $menu = $this->orderCategorias($categorias);
    require VIEWS_PATH . '/gestionCategoriasView.php';
  }

  public function orderCategorias($categorias)
  {
    $menu = [];
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

  public function getCategoriasHijas($categorias)
  {
    $cats = [];
    foreach ($categorias as $item) {
      if ($item->getCodpadre() !== null) {
        $cats[] = $item;
      }
    }
    return $cats;
  }

  public function getCategoriasPadre($categorias)
  {
    $cats = [];
    foreach ($categorias as $item) {
      if ($item->getCodpadre() == null) {
        $cats[] = $item;
      }
    }
    return $cats;
  }

  public function borrarCategoria($id)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $gestorArticulos = new GestorArticulos($con);
    $articulos = $gestorArticulos->getArticulosByCategoria($id);
    $catHijas = $gestor->getCategoriasByidPadre($id);
    if ($articulos > 0) {
      header('Location: ?action=gestion_categorias&error_borrado=true');
    } else if ($catHijas > 0) {
      header('Location: ?action=gestion_categorias&cat_padre=true');
    } else {
      $gestor->borrarCategoria($id);
    }
  }

  public function nuevaCategoria($error)
  {
    $codigo_duplicado = $error;
    $categorias = $this->getCategorias();
    $categiasPadre = $this->getCategoriasPadre($categorias);
    require VIEWS_PATH . '/nuevaCategoriaView.php';
  }

  public function nueva_categoria_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);

    if (isset($_POST['codigo'])) {
      $codigo = $_POST['codigo'];
      $result = $gestor->buscarCodigo($codigo);
      if (count($result) > 0) {
        header('Location: ?action=nueva_categoria&codigo_duplicado=true');
      }
      $categoriaPadre = $_POST['categoriaPadre'] !== 'null' ? $_POST['categoriaPadre'] : null;
      $categoria = new Categoria(
        $_POST['codigo'],
        $_POST['nombre'],
        1,
        $categoriaPadre,
      );
      $gestor->insertar($categoria);
    }
  }

  public function edicion_categoria($id)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorCategorias($con);
    $categoria = $gestor->buscarCodigo($id)[0];
    $categorias = $this->getCategorias();
    $categiasPadre = $this->getCategoriasPadre($categorias);
    require VIEWS_PATH . '/edicionCategoriaView.php';

  }

  public function edicion_categoria_check()
  {
    if (isset($_POST['nombre'])) {
      $con = conectar_db_pdo();
      $gestor = new GestorCategorias($con);

      $gestorArticulos = new GestorArticulos($con);
      $id = $_POST['codigo'];
      $codigoAnterior = $_POST['codigoAnterior'];
      $articulos = $gestorArticulos->getArticulosByCategoria($codigoAnterior);
      $catHijas = $gestor->getCategoriasByidPadre($codigoAnterior);

      if ($articulos > 0) {
        header('Location: ?action=gestion_categorias&error_borrado=true');
      } else if ($catHijas > 0) {
        header('Location: ?action=gestion_categorias&cat_padre=true');
      } else {
        $categoriaPadre = $_POST['categoriaPadre'] !== 'null' ? $_POST['categoriaPadre'] : null;
        $categoria = new Categoria(
          $_POST['codigo'],
          $_POST['nombre'],
          $_POST['activo'],
          $categoriaPadre
        );
        $gestor->modificar($categoria,$codigoAnterior);
      }

    }
  }
}
?>