<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');

//include 'config/seguridad.php';

class HeaderController
{

  public function cargarHeader()
  {
    $dni = isset($_SESSION['dni']) ? true : null;
    $admin = (isset($_SESSION['rol'])&&$_SESSION['rol']=='admin') ? true : null;
    $editor = (isset($_SESSION['rol'])&&$_SESSION['rol']=='editor') ? true : null;
    require VIEWS_PATH . '/cabecera.php';
  }
}
?>