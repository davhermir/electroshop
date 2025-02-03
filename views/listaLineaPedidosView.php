<h3>Lineas Pedido</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Codigo Artículo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Descuento %</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
        foreach ($pedidos as $pedido) {
            echo '<tr>';
            echo '<td>' . $pedido->getCodArticulo() . '</td>';
            echo '<td>' . $pedido->getCantidad() . '</td>';
            echo '<td>' . $pedido->getPrecio() . '</td>';
            echo '<td>' . $pedido->getDescuento() . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>