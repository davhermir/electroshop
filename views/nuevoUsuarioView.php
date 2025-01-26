<h1>Nuevo Cliente</h1>
    <form method="post" action="?action=nuevo_usuario_check" name="f1">
        <label for="dni">DNI:</label> <input maxlength="9" size="9" name="dni" id="dni" required><br>
        <?php
        if ($dni_duplicado) {
            echo "<p style='color:red';>Dni duplicado</p>";
        } else if ($dni_error) {
            echo "<p style='color:red';>Dni incorrecto</p>";
        }
        ?>
        <br>
        <label for="nombre">Nombre:</label>
        <input maxlength="30" size="40" name="nombre" id="nombre" required><br><br>
        <label for="correo">Correo electrónico:</label>
        <input maxlength="30" size="30" name="correo" id="correo" type="email" required><br><br>
        <?php
        if ($correo_duplicado) {
            echo "<p style='color:red';>Correo ya utilizado en otra cuenta</p>";
        }
        ?>
        <label for="clave">Contraseña: </label>
        <input type="password" name="clave" id="clave" required><br><br>

        <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
        <input name="Enviar" value="Enviar datos" type="submit"><br>
    </form>