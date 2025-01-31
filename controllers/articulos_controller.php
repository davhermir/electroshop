<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/Articulo.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/GestorArticulos.php');


class ArticulosController
{

  public function listarArticulos($pagina, $pags, $ini, $asc, $codigo, $cat)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    $admin = (isset($_SESSION['rol'])&&$_SESSION['rol']=='admin') ? true : false;
    $num_total_registros = $gestor->countTotalArticulos($cat,$admin);
    $total_paginas = ceil($num_total_registros / $pags);
    $codigoArticulo = $codigo;
    $res = [];
    if ($asc == "asc") {
      $res = $gestor->mostrarAsc(false, $ini, $pags, $cat,$admin);
    } else {
      $res = $gestor->mostrarAsc(true, $ini, $pags, $cat,$admin);
    }

    require VIEWS_PATH . '/listaArticulosView.php';
  }

  public function buscarArticulos($pagina, $pags, $ini, $nombre)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    $admin = (isset($_SESSION['rol'])&&$_SESSION['rol']=='admin') ? true : false;
    $num_total_registros = $gestor->countTotalArticulosNombre($nombre,$admin);
    $total_paginas = ceil($num_total_registros / $pags);
    $res = $gestor->buscar($nombre, $ini, $pags,$admin);

    require VIEWS_PATH . '/listaArticulosView.php';
  }

  public function confirm_borrar_articulos($codigo)
  {
    $borrado = "articulo";
    $articulo = $codigo;
    require VIEWS_PATH . '/borrarArticuloView.php';
  }

  public function borrararArticulos($codigo)
  {

    // ACABAR ESTA PARTE
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    $res = $gestor->eliminar($codigo);
    $codigoArticulo = $codigo;
    if ($res) {
      require VIEWS_PATH . '/listaArticulosView.php';
    } else {
      require VIEWS_PATH . '/listaArticulosView.php';
    }

  }

  public function nuevo_articulo($error, $categorias)
  {
    $fileSaveError = null;
    $fileError = null;
    $emptyFieldsError = null;
    $codigo_duplicado = null;
    $codigo_error = null;
    if ($error) {
      switch ($error) {
        case 'fileSaveError':
          $fileSaveError = true;
          break;
        case 'fileError':
          $fileError = true;
          break;
        case 'emptyFieldsError':
          $emptyFieldsError = true;
          break;
        case 'codigo_duplicado':
          $codigo_duplicado = true;
          break;
        case 'codigo_error':
          $codigo_error = true;
          break;
      }
    }

    require VIEWS_PATH . '/nuevoArticuloView.php';
  }
  public function nuevo_articulo_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['codigo'])) {
        if (
          isset($_FILES['img']) && $_FILES['img']['size'] > 0 && isset($_POST['codigo']) && isset($_POST['nombre'])
          && isset($_POST['descripcion']) && isset($_POST['categoria']) && isset($_POST['precio']) && isset($_POST['descuento'])
        ) {
          $nombretemporal = $_FILES['img']['tmp_name'];
          $nombre_archivo = $_FILES['img']['name'];
          $ruta = IMG_PATH . '/' . $nombre_archivo;
          list($ancho, $alto, $tipos, $atributos) = getimagesize($nombretemporal);
          if ($_FILES['img']['size'] <= 3000000 && $ancho && $ancho <= 200 && $alto <= 200) {
            if (move_uploaded_file($nombretemporal, $ruta)) {
              $codigo = $_POST['codigo'];
              if ($gestor->comprobar_codigo($codigo)) {
                $result = $gestor->buscarCodigo($codigo);
                if (count($result) > 0) {
                  header("Location: ?action=nuevo_articulo&codigo_duplicado=true");
                } else {
                  $articulo = new Articulo(
                    $_POST['codigo'],
                    $_POST['nombre'],
                    $_POST['descripcion'],
                    $_POST['categoria'],
                    $_POST['precio'],
                    $nombre_archivo,
                    $_POST['descuento'],
                    1

                  );
                  $gestor->insertar($articulo);
                }
              } else {
                header("Location: ?action=nuevo_articulo&codigo_error=true");
              }
            } else {
              header("Location: ?action=nuevo_articulo&fileSaveError=true");
            }
          } else {
            header("Location: ?action=nuevo_articulo&fileError=true");
          }
        } else {
          header("Location: ?action=nuevo_articulo&emptyFieldsError=true");
        }

      }
    }

  }
  public function editar_articulo($codigoArticulo,$categorias, $error)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    $emptyFieldsError = null;
    $fileError = null;
    $fileSaveError = null;
    switch ($error) {
      case "emptyFieldsError":
        $emptyFieldsError = true;
        break;
      case "fileError":
        $fileError = true;
        break;
      case "fileSaveError":
        $fileSaveError = true;
        break;
    }
    $data = $gestor->buscarCodigo($codigoArticulo);
    if (count($data) > 0) {
      $articulo = $data[0];
    } else {
      header('Location: action=mostrar_articulos');
    }
    require VIEWS_PATH . '/edicionArticuloView.php';
  }

  public function editar_articulo_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorArticulos($con);
    if (isset($_POST['codigo'])) {
      $codigo = $_POST['codigo'];
      $articulo = "";
      if (isset($_POST['codigo']) && isset($_POST['nombre'])
      && isset($_POST['descripcion']) && isset($_POST['categoria']) && isset($_POST['precio']) && isset($_POST['descuento'])
      ) {

        $mismaImagen = true;
        if (isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
          $nombretemporal = $_FILES['img']['tmp_name'];
          $nombre_archivo = $_FILES['img']['name'];
          $mismaImagen = $_POST['imagenAnterior'] == $nombre_archivo;
        }
        if ($mismaImagen) {
          $articulo = new Articulo(
            $_POST['codigo'],
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['categoria'],
            $_POST['precio'],
            $_POST['imagenAnterior'],
            $_POST['descuento'],
            $_POST['activo'],
          );
        } else {
          $ruta = "Images/" . $nombre_archivo;
          list($ancho, $alto, $tipos, $atributos) = getimagesize($nombretemporal);
          if ($_FILES['img']['size'] <= 3000000 && $ancho && $ancho <= 200 && $alto <= 200) {
            if (move_uploaded_file($nombretemporal, $ruta)) {
              $articulo = new Articulo(
                $_POST['codigo'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['categoria'],
                $_POST['precio'],
                $nombre_archivo,
                $_POST['descuento'],
                $_POST['activo'],
              );
            } else {
              header("Location: ?action=editar_articulo&id=$codigo&fileSaveError=true");
            }
          } else {
            header("Location: ?action=editar_articulo&id=$codigo&fileError=true");
          }
        }

        $gestor->modificar($articulo);
      } else {
        header("Location: ?action=editar_articulo&id=$codigo&emptyFieldsError=true");
      }
    }
  }
}
?>