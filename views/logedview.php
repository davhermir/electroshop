<div class="login center">
    <table align="center">
        <tr>
            <td colspan="2">
                <h3><?= $user ?></h3>
            </td>
        </tr>
        <tr>
            <td>
                Cerrar sesión: <a href="?action=logout"><i class="bi bi-box-arrow-right"></i></a>
            </td>
        </tr>
        <tr>
            <td colspan="2"><a href="?action=passwd">Cambiar Contraseña</a> </td>
        </tr>
    </table>
    <?php
    if (isset($passwd)) {
        echo "*Contrseña cambiada correctamente";
    }
    if (isset($_SESSION['carrito']) && count($_SESSION['carrito'])>0) {
        ?>
        <hr>
        <div mt-4>
        <a href="?action=mostrar_carrito" style="text-decoration: none; font-size: 20px;">
        <span>Carrito</span>
            🛒 (<?php echo isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>)
        </a>
        </div>
    <?php } ?>
</div>
