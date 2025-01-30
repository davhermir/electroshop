<h1>Artículos</h1>
<?php
if (isset($codigoArticulo)) {
    echo "*Artículo con codigo " . $codigoArticulo . " eliminado";
} else if (isset($errorborrado)) {
    echo "*No se ha podido borrar el artículo";
}
?>

<div class="flexmenu space">
    <div class="centrar-elemento flexmenu">
        Orden:        
        <a href="?action=mostrar_articulos&order=asc<?= isset($cat) ? '&cat='.$cat : ''; ?>"><button class="btn btn-success">ASC</button></a>
        <a href="?action=mostrar_articulos&order=desc<?= isset($cat) ? '&cat='.$cat : ''; ?>"><button class="btn btn-success">DESC</button></a>

        <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor')) { ?>
            <a href="?action=nuevo_articulo"><button class="btn btn-success">Nuevo Articulo</button></a>
        <?php } ?>
    </div>
</div>
<section>
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            if (isset($res) && !empty($res)) {
                foreach ($res as $articulo) { ?>
                    <!--<article class="articulo">-->
                    <div class="col mb-5">
                        <div class="card">
                        <?php if($articulo->getDescuento()&&$articulo->getDescuento()>0){ ?>
                            <div class="badge bg-success text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
                                <?php echo '-' . htmlspecialchars($articulo->getDescuento()) . '%'; ?>
                            </div>
                            <?php } ?>
                            <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'editor')) { ?>
                                <div class="badge bg-light text-white position-absolute top-0 start-0">
                                    <a href="?action=editar_articulo&id=<?= $articulo->getCodigo() ?>"><i
                                            class="bi bi-pencil"></i></a>
                                </div>
                            <?php } ?>
                            <img class="card-img-top" src="images/<?php echo htmlspecialchars($articulo->getImagen()) ?>"
                                alt="Imagen del artículo">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo htmlspecialchars($articulo->getNombre()) ?></h5>
                                    <p><?php echo htmlspecialchars($articulo->getDescripcion()) ?></p>
                                    <?php if ($articulo->getDescuento() == 0) { ?>
                                        <p><?php echo htmlspecialchars($articulo->getPrecio()) . '€' ?></p>
                                        <?php
                                    } else { ?>
                                        <div class="row-flex">
                                            <del color="grey"><?php echo htmlspecialchars($articulo->getPrecio()) . 'PVPR' ?></del>
                                            <div>
                                                <?php echo htmlspecialchars($articulo->calcularPrecioOferta() . '€') ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <form method='POST' action="?action=add_carrito">
                                        <input type='hidden' name='id_producto' value=<?=$articulo->getCodigo()?>>
                                        <input type='number' name='cantidad' value='1' min='1' style='width: 50px;' required>
                                        <button type='submit' class="btn btn-success">Añadir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>
    </div>
</section>
<div class="text-center">
    <?php
    $total_paginas;
    $num_total_registros;
    if ($total_paginas > 1) {
        for ($i = 1; $i <= $total_paginas; $i++) {
            if ($pagina == $i) {
                echo $pagina . " ";
            } else {
                if (isset($asc)) {
                    echo "<a href='/?action=mostrar_articulos&pagina=" . $i . "&order=" . $asc . "'>" . $i . "</a>  ";
                } else if (isset($nombre)) {
                    echo "<a href='/?action=buscar_articulo&pagina=" . $i . "&nombre=" . $nombre . "'>" . $i . "</a>  ";
                } else {
                    echo "<a href='/?pagina=" . $i . "'>" . $i . "</a>  ";
                }
            }
        }
    }
    echo "  | Paginas:" . $total_paginas . "  | Total elementos: " . $num_total_registros;
    ?>
</div>