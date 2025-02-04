<h3>Pedidos</h3>
<form method="get" action="" name="buscarPedido">
                    <input type="hidden" name="action" value="ver_pedido">
                    <div class="flex-row">
                        <label for="id_pedido"></label>
                        <input type="text" name="id_pedido" id="id_pedido" placeholder="Buscar Pedido"
                            aria-label="Buscar Pedido">
                        <button type="submit" class="btn btn-default"><i class="bi bi-search"></i></button>
                    </div>
                </form>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Cod Usuario</th>
            <th>Fecha</th>
            <th>Precio Total</th>
            <th>Estado</th>
            <th>Información</th>
            <th>Activo</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
        foreach ($pedidos as $pedido) {
            $estado = "En preparación";
            switch ($pedido->getEstado()) {
                case "1":
                    $estado = "En preparación";
                break;
                case "2";
                $estado = "Enviado";
                break;
                case "3":
                    $estado = "Finalizado";
                break;
            }
            $activo = $pedido->getActivo() == 1 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>';
            echo '<tr>';
            echo '<td>' . $pedido->getIdPedido() . '</td>';
            echo '<td>' . $pedido->getCodUsuario() . '</td>';
            echo '<td>' . $pedido->getFecha() . '</td>';
            echo '<td>' . $pedido->getTotal() . '</td>';
            echo '<td>' . $estado . '</td>';
            echo '<td><a href="?action=info_pedido&id_pedido=' . $pedido->getIdPedido() . '"><i class="bi bi-info-circle"></i></a></td>';
            echo '<td>' . $activo . '</td>';
            echo '<td><a href="?action=edicion_pedido&id_pedido=' . $pedido->getIdPedido() . '"><i class="bi bi-pencil"></i></a></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
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
                    echo "<a href='/?action=ver_pedidos&pagina=" . $i . "&order=" . $asc . "'>" . $i . "</a>  ";
                }
            }
        }
    }
    echo "  | Paginas:" . $total_paginas . "  | Total elementos: " . $num_total_registros;
    ?>
</div>