<h3>Pedidos</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Fecha</th>
            <th>Precio Total</th>
            <th>Estado</th>
            <th>Información</th>
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
            echo '<tr>';
            echo '<td>' . $pedido->getIdPedido() . '</td>';
            echo '<td>' . $pedido->getFecha() . '</td>';
            echo '<td>' . $pedido->getTotal() . '</td>';
            echo '<td>' . $estado . '</td>';
            echo '<td><a href="?action=info_pedido&id_pedido=' . $pedido->getIdPedido() . '"><i class="bi bi-info-circle"></i></a></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>