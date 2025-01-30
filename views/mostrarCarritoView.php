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
                <div class="d-flex">
                    <img src=<?= $imagen ?> alt="Product" class="product-img me-3">
                    <div>
                        <h6><?=$item["nombre"] ?></h6>
                        <p class="mb-0"><?=$item["cantidad"]?> x <?=$item["precio"]?></p>
                    </div>
                </div>
                <span><?=$subtotal?></span>
            </div>
                <?php } ?>
        </div>

        <div class="col-md-4">
            <div class="cart-summary">
                <h5>Resumen Pedido</h5>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span><?=$total_carrito?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>$5.00</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span class="total-price">Total:</span>
                        <span class="total-price"><?=($total_carrito+5)?></span>
                    </li>
                </ul>
                <button class="btn btn-checkout" disabled>Proceder al pago</button>
            </div>
        </div>
    </div>
</div>