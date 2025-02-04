<div class="login center">
    <form action="?action=check_login" method="post">
        <table align="center">
            <h3 class="mt-5">Iniciar Sesión</h3>
            <tr>
                <td colspan="2">
                    <input maxlength="30" size="20" name="correo" id="correo" type="email" placeholder="Email" required><br><br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="password" id="key" name="key" placeholder="Password" required>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Login"></td>
            </tr>
            <?php echo isset($error_incomplete) ? "Rellena todos los campos" : ""; ?>
        </table>
        <?php
        if(isset($incorrect_pwd)){
            echo '*Contraseña incorrecta';
        }
        if(isset($new_passwd)){
            echo "*Contraseña cambiada correctamente";
        }
        ?>
        <table align="center" class="mt-5">
            <tr>
                <td colspan="2"><a href="?action=passwd">Recuperar Contraseña</a> </td>
            </tr>
            <tr>
                <td colspan="2"><a href="?action=nuevo_usuario">Nuevo Usuario</a> </td>
            </tr>
        </table>
    </form>
    <?php
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


