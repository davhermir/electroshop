<?php
//Solucionar problemas buffer headers
ob_start();
define('VIEWS_PATH', __DIR__ . '/views');
define('IMG_PATH', __DIR__ . '/images');
//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$action = isset($_GET['action']) ? $_GET['action'] : 'mostrar_articulos';
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/articulos_controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/header_controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/categorias_controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/usuarios_controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/carrito_controller.php');
include($_SERVER['DOCUMENT_ROOT'] . '/controllers/pedidos_controller.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="global.css">
    <link rel="apple-touch-icon" sizes="57x57" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="aac8c418f660b763034d5117a6a0f233.ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="aac8c418f660b763034d5117a6a0f233.ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="aac8c418f660b763034d5117a6a0f233.ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="aac8c418f660b763034d5117a6a0f233.ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="aac8c418f660b763034d5117a6a0f233.ico/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="global.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>

<div>
    <?php
    $categoriasController = new CategoriasController();
    $usersController = new UsuariosController();
    $headerController = new HeaderController();
    $headerController->cargarHeader();
    $categoriasController->listarCategoriasNav();
    //include($_SERVER['DOCUMENT_ROOT'] . '/views/nav.php'); 
    $pags = 2;
    $pagina = 1;
    $inicio = 0;
    $order = null;
    $codigoArticulo = null;
    $cat = null;
    //echo "<script>console.log('PHP: " . $action . "');</script>";
    switch ($action) {
        case 'mostrar_articulos':
            $articulosController = new ArticulosController();
            $pags = 6;
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                $inicio = ($pagina - 1) * $pags;
            } else {
                $pagina = 1;
                $inicio = 0;
            }
            $order = isset($_GET["order"]) ? $_GET["order"] : null;
            $codigoArticulo = isset($_GET["codigoArticulo"]) ? $_GET["codigoArticulo"] : null;
            $errorborrado = isset($_GET["errorborrado"]) ? $_GET["errorborrado"] : null;
            $cat = isset($_GET["cat"]) ? $_GET["cat"] : null;
            $articulosController->listarArticulos($pagina, $pags, $inicio, $order, $codigoArticulo, $cat);
            break;
        case 'buscar_articulo':
            $pags = 6;
            $articulosController = new ArticulosController();
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                $inicio = ($pagina - 1) * $pags;
            } else {
                $pagina = 1;
                $inicio = 0;
            }
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : null;
            //echo "<script>console.log('PHP: " . $nombre . "');</script>";
            $articulosController->buscarArticulos($pagina, $pags, $inicio, $nombre);
            break;
        case 'confirm_borrar_articulo':
            $articulosController = new ArticulosController();
            if (isset($_GET['codigo'])) {
                $codigoArticulo = $_GET['codigo'];
            }
            $articulosController->confirm_borrar_articulos($codigoArticulo);
            break;
        case 'nuevo_articulo':
            $categorias = $categoriasController->getCategoriasArticulos();
            $articulosController = new ArticulosController();
            $error = null;
            if (isset($_GET['fileSaveError']) && $_GET['fileSaveError']) {
                $error = 'fileSaveError';
            } else if (isset($_GET['fileError']) && $_GET['fileError']) {
                $error = 'fileError';
            } else if (isset($_GET['codigo_duplicado']) && $_GET['codigo_duplicado']) {
                $error = 'codigo_duplicado';
            } else if (isset($_GET['codigo_error']) && $_GET['codigo_error']) {
                $error = 'codigo_error';
            }
            $articulosController->nuevo_articulo($error, $categorias);
            break;
        case 'nuevo_articulo_check':
            $articulosController = new ArticulosController();
            $articulosController->nuevo_articulo_check();
            break;
        case 'editar_articulo':
            $categorias = $categoriasController->getCategoriasArticulos();
            $articulosController = new ArticulosController();
            $error = null;
            $codigoArticulo = null;
            if (isset($_GET['fileSaveError']) && $_GET['fileSaveError']) {
                $error = 'fileSaveError';
            } else if (isset($_GET['fileError']) && $_GET['fileError']) {
                $error = 'fileError';
            } else if (isset($_GET['emptyFieldsError']) && $_GET['emptyFieldsError']) {
                $error = 'emptyFieldsError';
            }
            if (isset($_GET['id'])) {
                $codigoArticulo = $_GET['id'];
            } else {
                header('Location: ?action=mostrar_articulos');
            }
            $articulosController->editar_articulo($codigoArticulo, $categorias, $error);
            break;
        case 'editar_articulo_check':
            $articulosController = new ArticulosController();
            $articulosController->editar_articulo_check();
            break;
        case 'check_login':
            if (isset($_POST['correo']) && isset($_POST['key'])) {
                $usu = $_POST['correo'];
                $pwd = $_POST['key'];
                $usersController->login($usu, $pwd);
            }
            break;
        case 'nuevo_usuario':
            $error = null;
            if (isset($_GET['dni_duplicado']) && $_GET['dni_duplicado']) {
                $error = 'dni_duplicado';
            } else if (isset($_GET['dni_error']) && $_GET['dni_error']) {
                $error = 'dni_error';
            } else if (isset($_GET['correo_duplicado']) && $_GET['correo_duplicado']) {
                $error = 'correo_duplicado';
            }
            $usersController->nuevo_usuario($error);
            break;
        case 'nuevo_usuario_check':
            $usersController->nuevo_usuario_check();
            break;
        case 'cuenta':
            $error = null;
            if (isset($_GET['correo_duplicado']) && $_GET['correo_duplicado']) {
                $error = 'correo_duplicado';
            }
            $usersController->menu_cuenta(null);
            break;
        case 'update_usuario':
            $usersController->update_usuario_check();
            break;
        case 'passwd':
            $error = null;
            if (isset($_GET['incorrect_mail'])) {
                $error = 'incorrect_mail';
            }
            if (isset($_GET['error_update'])) {
                $error = 'error_update';
            }
            if (isset($_GET['email_duplicado'])) {
                $error = 'email_duplicado';
            }
            $usersController->cambio_paswd($error);
            break;
        case 'new_pwd':
            $error = null;
            if (isset($_POST['correo']) && $_POST['key']) {
                $mail = $_POST['correo'];
                $pwd = $_POST['key'];
                //echo "<script>console.log('PHP: ". $mail ." ". $pwd . "');</script>";
                $usersController = new UsuariosController();
                $usersController->cambio_paswd_check($mail, $pwd);
            } else {
                $error = 'error_incomplete';
                $usersController->cambio_paswd($error);
            }
            break;
        case 'logout':
            $usersController->logout();
            break;
        case 'gestion_categorias':
            $error = null;
            if (isset($_GET['error_borrado'])) {
                $error = 'error_borrado';
            }
            if (isset($_GET['cat_padre'])) {
                $error = 'cat_padre';
            }
            $categoriasController->getCategoriasView($error);
            break;
        case 'borrar_categoria';
            $id = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $categoriasController->borrarCategoria($id);
            } else {
                header('Location: ?action=gestion_categorias');
            }
            break;
        case 'nueva_categoria':
            $error = null;
            if (isset($_GET['codigo_duplicado'])) {
                $error = true;
            }
            $categoriasController->nuevaCategoria($error);
        case 'nueva_categoria_check':
            $categoriasController->nueva_categoria_check();
            break;
        case 'edicion_categoria':
            $id = null;
            if (isset($_GET['id_cat'])) {
                $id = $_GET['id_cat'];
            }
            $categoriasController->edicion_categoria($id);
            break;
        case 'edicion_categoria_check':
            $categoriasController->edicion_categoria_check();
            break;
        case 'add_carrito':
            $carritoController = new CarritoController();
            $carritoController->add();
            break;
        case 'restar_carrito':
            $id = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            $carritoController = new CarritoController();
            $carritoController->restar($id);
            break;
        case 'sumar_carrito':
            $id = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            $carritoController = new CarritoController();
            $carritoController->sumar($id);
            break;
        case 'gestion_usuarios':
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                $inicio = ($pagina - 1) * $pags;
            } else {
                $pagina = 1;
                $inicio = 0;
            }
            $usersController->gestion_usuarios($pagina, $inicio);
            break;
        case "gestion_user":
            $dni = null;
            if (isset($_GET['dni'])) {
                $dni = $_GET['dni'];
            }
            $usersController->gestion_user($dni);
            break;
        case 'gestion_user_update':
            $usersController->gestion_user_update();
            break;
        case 'mostrar_carrito':
            $carritoController = new CarritoController();
            $carritoController->mostrar_carrito();
            break;
        case 'eliminar_carrito':
            $carritoController = new CarritoController();
            $carritoController->eliminar_carrito();
            break;
        case 'success':
            $pedidosController = new PedidosController();
            $pedidosController->insertar();
            break;
        case 'ver_pedidos':
            $pags = 6;
            $idPedido = null;
            if (isset($_GET['id_pedido'])) {
                $idPedido = $_GET['id_pedido'];
            }
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
                $inicio = ($pagina - 1) * $pags;
            } else {
                $pagina = 1;
                $inicio = 0;
            }
            $pedidosController = new PedidosController();
            if(isset($_SESSION['rol'])&&($_SESSION['rol']=='admin')||$_SESSION['rol']=='editor'){
            $pedidosController->gestion_pedidos($pagina, $pags, $inicio, $idPedido);
            }else{
            $pedidosController->ver_pedidos();
            }
            break;
        case 'info_pedido':
            $idPedido = null;
            if (isset($_GET['id_pedido'])) {
                $idPedido = $_GET['id_pedido'];
            }
            $pedidosController = new PedidosController();
            $pedidosController->info_pedido($idPedido);
            break;
        case 'edicion_pedido':
            $idPedido = null;
            if (isset($_GET['id_pedido'])) {
                $idPedido = $_GET['id_pedido'];
            }
            $pedidosController = new PedidosController();
            $pedidosController->editar_pedido($idPedido);
            break;
        case 'edicion_pedido_check':
            $pedidosController = new PedidosController();
            $pedidosController->check_editar_pedido();
            break;
        default:
            http_response_code(404);
            echo "Página no encontrada";
            break;
    }
    ?>
</div>
<?php
if (isset($_SESSION['dni'])) {
    $usersController->logedView();
    //include($_SERVER['DOCUMENT_ROOT'] . '/views/logedview.php');
} else {
    $msg = null;
    if (isset($_GET['incorrect_pwd'])) {
        $msg = 'incorrect_pwd';
    }
    if (isset($_GET['new_passwd'])) {
        $msg = 'new_passwd';
    }
    $usersController->loginView($msg);
    //include($_SERVER['DOCUMENT_ROOT'] . '/views/loginview.php');
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/views/pie.php');
ob_end_flush() ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>