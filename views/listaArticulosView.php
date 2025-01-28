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
            <p>Orden:</p>
            <a href="?action=mostrar_articulos&order=asc"><button>ASC</button></a>
            <a href="?action=mostrar_articulos&order=desc"><button>DESC</button></a>
        </div>
        <?php  if (isset($_SESSION['rol']) && $_SESSION['rol']=='admin' || $_SESSION['rol']=='editor') { ?>
            <div class="centrar-elemento">
                <a href="?action=nuevo_articulo"><button>Nuevo Articulo</button></a>
            </div>

        <?php  } ?>
    </div>
        <section class="articulos">
            <?php
                if(isset($res) && !empty($res)) {
                foreach ($res as $articulo) { ?>
                <article class="articulo">
                    <img src="images/<?php echo htmlspecialchars($articulo->getImagen()) ?>" alt="Imagen del artículo">
                    <div class="info">
                        <h2><?php echo htmlspecialchars($articulo->getNombre()) ?></h2>
                        </p>
                        <p><?php echo htmlspecialchars($articulo->getDescripcion()) ?></p>
                        <?php if($articulo->getDescuento()==0) {?>
                        <p><?php echo htmlspecialchars($articulo->getPrecio()) . '&euro'?></p>
                        <?php
                        }else{ ?>
                            <div class="row-flex">
                            <del color="grey"><?php echo htmlspecialchars($articulo->getPrecio()) . 'PVPR'?></del>
                            <div>
                            <?php echo htmlspecialchars($articulo->calcularPrecioOferta() . '€') ?>
                            <?php echo '-' . htmlspecialchars($articulo->getDescuento()) . '%' ?>
                            </div>
                            </div>
                        <?php } if (isset($_SESSION['rol']) && $_SESSION['rol']=='admin' || $_SESSION['rol']=='editor') { 
                            echo '<td><a href="?action=editar_articulo&id=' . $articulo->getCodigo() . '"><i class="bi bi-pencil"></i></a></td>'; 
                         } ?>
                    </div>
                </article>
            <?php } 
            }?>
        </section>
        <div>
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
        echo "  | Paginas:" . $total_paginas  . "  | Total elementos: " . $num_total_registros;
        ?>
        </div>