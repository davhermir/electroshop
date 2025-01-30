<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/conectar_db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/Usuario.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/UsuarioShort.php');
include($_SERVER['DOCUMENT_ROOT'] . '/models/GestorUsuarios.php');
include($_SERVER['DOCUMENT_ROOT'] . '/libs/lib.php');
class UsuariosController
{

  public function listarUsuarios($pagina, $pags, $ini, $asc, $codigo)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $num_total_registros = $gestor->countTotalUsuarios();
    $total_paginas = ceil($num_total_registros / $pags);
    $codigoUsuario = $codigo;
    $res = [];
    if ($asc == "asc") {
      $res = $gestor->mostrarAsc(false, $ini, $pags);
    } else {
      $res = $gestor->mostrarAsc(true, $ini, $pags);
    }

    require VIEWS_PATH . '/listaUsuariosView.php';
  }

  public function buscarUsuarios($pagina, $pags, $ini, $nombre)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $num_total_registros = $gestor->countTotalUsuariosNombre($nombre);
    $total_paginas = ceil($num_total_registros / $pags);
    $res = $gestor->buscar($nombre, $ini, $pags);

    require VIEWS_PATH . '/listaUsuariosView.php';
  }

  public function confirm_borrar_usuarios($codigo)
  {
    $borrado = "usuario";
    $articulo = $codigo;
    require VIEWS_PATH . '/borrarUsuarioView.php';
  }

  public function borrarUsuarios($codigo)
  {

    // ACABAR ESTA PARTE
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $res = $gestor->eliminar($codigo);
    $codigoArticulo = $codigo;
    if ($res) {
      require VIEWS_PATH . '/listaArticulosView.php';
    } else {
      require VIEWS_PATH . '/listaArticulosView.php';
    }

  }

  public function nuevo_usuario($error)
  {
    $dni_duplicado = null;
    $dni_error = null;
    $correo_duplicado = null;
    if ($error) {
      switch ($error) {
        case 'dni_duplicado':
          $dni_duplicado = true;
          break;
        case 'dni_error':
          $dni_error = true;
          break;
          case 'correo_duplicado':
            $correo_duplicado = true;
            break;
      }
    }

    require VIEWS_PATH . '/nuevoUsuarioView.php';

  }



  public function nuevo_usuario_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);

    if (isset($_POST['dni'])) {
      $dni = $_POST['dni'];
      $correo = $_POST['correo'];
      if ($gestor->checkDni($dni)) {
        header("Location: ?action=nuevo_usuario&dni_duplicado=true");
      } else if ($gestor->checkCorreo($correo)) {
        header("Location: ?action=nuevo_usuario&correo_duplicado=true");
      } else {
        $rol = isset($_POST['rol']) ? $_POST['rol'] : 'usuario';
        $user = new UsuarioShort(
          $_POST['dni'],
          $_POST['clave'],
          $_POST['nombre'],
          $_POST['correo'],
          $rol,
          1
        );
        $gestor->insertarShort($user);

      }
    }
  }


  public function nuevo_usuario_completo_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    if (isset($_POST['dni'])) {
      $dni = $_POST['dni'];
      if (comprobar_dni($dni)) {
        $result = $gestor->buscarDni($dni);
        if (count($result) > 0) {
          header("Location: ?action=nuevo_usuario&dni_duplicado=true");
        } else {
          $rol = isset($_POST['rol']) ? $_POST['rol'] : 'usuario';
          $user = new Usuario(
            $_POST['dni'],
            $_POST['clave'],
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['direccion'],
            $_POST['localidad'],
            $_POST['provincia'],
            $_POST['telefono'],
            $_POST['correo'],
            $rol,
            1
          );
          $gestor->insertar($user);
        }
      } else {
        header("Location: ?action=nuevo_usuario&dni_error=true");
      }
    }
  }
  public function cambio_paswd($error)
  {
    $error_update = null;
    $email_duplicado = null;
    switch ($error) {
      case "error_update":
        $error_update = true;
        break;
      case "email_duplicado":
        $email_duplicado = true;
        break;
      case "incorrect_mail":
        $incorrect_mail = true;
        break;
    }
    require VIEWS_PATH . '/recuperarPwdView.php';
  }

  public function cambio_paswd_check($email, $pwd)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    if ($gestor->checkCorreo($email)) {
      if ($gestor->updatePasswd($email, $pwd)) {
        header("Location: ?action=mostrar_articulos&new_passwd=true");
      } else {
        header("Location: ?action=passwd&error_update=true");
        echo "No se pudieron actualizar los datos.";
      }
    } else {
      header("Location: ?action=passwd&incorrect_mail=true");
    }
  }

  //Login - Logout
  public function login($nombre, $password)
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $gestor->login($nombre, $password);
  }

  public function logout()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $gestor->logout();
  }

  public function logedView()
  {
    $user = $_SESSION['nombre'];
    $passwd = isset($_GET['new_passwd']) ? true : null;
    include($_SERVER['DOCUMENT_ROOT'] . '/views/logedview.php');
  }

  public function loginView($msg)
  {
    $incorrect_pwd = null;
    $new_passwd = null;
    switch ($msg) {
      case 'incorrect_pwd':
        $incorrect_pwd = true;
        break;
      case 'new_passwd':
        $new_passwd = true;
        break;
    }
    include($_SERVER['DOCUMENT_ROOT'] . '/views/loginview.php');
  }

  public function menu_cuenta($error)
  {
    $mail_repetido = $error;
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $usuario = $gestor->buscarDni($_SESSION['dni'])[0];
    require VIEWS_PATH . '/menuCuentaView.php';
  }

  public function update_usuario_check()
  {
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);

    if (isset($_POST['nombre'])) {
      $checkMail = $gestor->checkCorreoUpdate($_POST['correo'], $_POST['dni']);
      if ($checkMail) {
        $user = new Usuario(
          $_POST['dni'],
          $_POST['clave'],
          $_POST['nombre'],
          $_POST['apellidos'],
          $_POST['direccion'],
          $_POST['localidad'],
          $_POST['provincia'],
          $_POST['telefono'],
          $_POST['correo'],
          $_POST['rol'],
          1
        );
        $gestor->modificar($user);
      } else {
        header('Location: ?action=menu&correo_duplicado=true');
      }
    }
  }

  public function gestion_usuarios($pag,$ini){
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $users=$gestor->getUsers($ini,$pag);
    $num_total_registros = $gestor->countTotalUsuarios();
    $total_paginas = ceil($num_total_registros / 10);
    require VIEWS_PATH . '/gestionUsuariosView.php';
  }

  public function gestion_user($dni){
    $con = conectar_db_pdo();
    $gestor = new GestorUsuarios($con);
    $usuario = $gestor->buscarDni($dni)[0];
    require VIEWS_PATH . '/edicionUsuarioView.php';
  }
}
?>