<div class="mt-3">
    <div class="row">
        <h3>Informe Mensual</h3>
        <div class="col-md-4">
            <div>
                <h5 class="bold">Pedidos Realizados</h5>
                <ul class="list-unstyled">
                    <li>
                        <span class="total-price">Total:</span>
                        <span class="total-price"><?= ($pedidosTotales) ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <h5 class="bold">Ingresos Totales</h5>
                <ul class="list-unstyled">
                    <li>
                        <span class="total-price">Total:</span>
                        <span class="total-price">€<?= ($ingresosTotales) ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
    <h5>Items Más Vendidos</h5>
        <?php
        foreach ($items as $key => $item) {
            ?>
            <div class="col-md-8">
                <div>
                    <ul class="list-unstyled">

                        <li>
                            <span>ID Articulo:</span>
                            <span class="bold"><?= ($key) ?></span>
                            --
                            <span>Cantidad:</span>
                            <span class="bold"><?= ($item) ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</div>