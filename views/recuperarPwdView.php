<div class="center">
    <form action="?action=new_pwd" method="post">
        <table align="center">
            <h3 class="ml-5">Cambiar Contraseña</h3>
            <tr>
                <td colspan="2">
                    <input maxlength="30" size="30" name="correo" id="correo" type="email" placeholder="Email" required><br><br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="password" id="key" name="key" placeholder="Password" required>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Cambiar Contraseña"></td>
            </tr>
            <?php echo isset($error_incomplete) ? "Rellena todos los campos" : ""; ?>
        </table>
        <?php
        if(isset($incorrect_mail)){
            echo '*Email incorrecto';
        }
        if(isset($email_duplicado)){
            echo "Email Duplicado";
        }
        if(isset($error_update)){
            echo "Error en update";
        }
        ?>
    </form>
</div>