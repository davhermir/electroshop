<div class="login center">
        <table align="center">
            <tr>
                <td colspan="2">
                    <?=$user  . ' logged';?>
                </td>
                <td>
                <a href="?action=logout"><i class="bi bi-box-arrow-right"></i></a>
                </td>
            </tr>
            <tr>
            <td colspan="2"><a href="?action=passwd">Cambiar Contraseña</a> </td>
            </tr>
        </table>
        <?php
        if(isset($passwd)){
            echo "*Contrseña cambiada correctamente";
        }
        ?>
</div>