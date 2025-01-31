<div class="container mt-3">
    <div class="row">
        <!-- Shopping Cart Items -->
        <div class="col-md-8">
            <h3>Tu carrito</h3>
            <?php
            $total_carrito = 0;
            foreach ($carrito as $index => $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $total_carrito = $subtotal + $total_carrito;
                $imagen = "images/" . $item["img"];
                ?>

                <div class="cart-item">
                    <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded"
                        style="width: 100%;">
                        <div class="d-flex flex-row">
                            <img class="litle-img rounded" src=<?= $imagen ?> alt="Product" class="product-img me-3">
                            <div class="ml-2">
                                <span class="bold d-block"><?= $item["nombre"] ?></span>
                                <span class="spec deleted"><?= $item['id'] ?></span>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <span class="d-block"> €<?= $item["precio"] ?></span>
                        </div>
                        <div class="d-flex flex-row align-items-center" style="min-width: 100px;">
                            <a class="btn btn-outline-secondary btn-sm btn-number"
                                href="?action=restar_carrito&id=<?= $item['id'] ?>"><i class="bi bi-chevron-down"></i></a>
                            <span><?= $item['cantidad'] ?></span>
                            <a class="btn btn-outline-secondary btn-sm btn-number"
                                href="?action=sumar_carrito&id=<?= $item['id'] ?>"><i class="bi bi-chevron-up"></i></a>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <span class="d-block ml-5 font-weight-bold">€<?= $subtotal ?></span>
                            <form method='POST' action='?action=eliminar_carrito' style='display: inline;'>
                                <input type='hidden' name='index' value='<?=$index?>'>
                                <button class="btn btn-light" type='submit' style="background-color:none"><i class="bi bi-trash3"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-4">
            <div class="cart-summary">
                <h5>Resumen Pedido</h5>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>€<?= $total_carrito ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>€5.00</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="total-price">Total:</span>
                        <span class="total-price">€<?= ($total_carrito + 5) ?></span>
                    </li>
                </ul>
                <button class="btn btn-checkout" disabled>Proceder al pago</button>
            </div>
        </div>
    </div>
</div>