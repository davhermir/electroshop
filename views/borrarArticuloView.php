<?php
/*
// Conectar 
include 'seguridad.php';
include 'Articulo.php';
include 'GestorArticulos.php';

$articulo = "";
$error_borrado = false;

if(isset($_GET['codigo'])){
    $articulo = $_GET['codigo'];
}
// Comprobar si se ha enviado una solicitud de eliminación
if (isset($_GET['eliminar'])) {
    $codigoEliminar = $_GET['codigo'];
    $resultado = $gestor->eliminar($codigoEliminar);
    if($resultado){
        header("Location: listaarticulos.php?codigo=$codigoEliminar");
    }else{
        header("Location: listaarticulos.php?errorborrado=true");
    }
    
}
echo "";

*/
?>
<h1> Está seguro de eliminar el arttículo <?=$articulo?> ? </h1>
    <a href="?action=mostrar_articulos&codigo=<?=$articulo?>&eliminar=true"><button class="btn btn-success boton boton">Sí</button></a>
    <a href="?action=mostrar_articulos"><button class="btn btn-success boton boton">No</button></a>
    

