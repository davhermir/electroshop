<h1>Nuevo Cliente</h1>
<form method="post" action="?action=nuevo_usuario_check" name="f1">
    <div class="form-group">
        <label for="dni">DNI:</label>
        <input class="form-control" maxlength="9" size="9" name="dni" id="dni" required><br>
        <?php
        if ($dni_duplicado) {
            echo "<p style='color:red';>Dni duplicado</p>";
        } else if ($dni_error) {
            echo "<p style='color:red';>Dni incorrecto</p>";
        }
        ?>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="30" size="40" name="nombre" id="nombre" required>
    </div>
    <div class="form-group">
        <label for="correo">Correo electrónico:</label>
        <input class="form-control" maxlength="30" size="30" name="correo" id="correo" type="email" required>
        <?php
        if ($correo_duplicado) {
            echo "<p style='color:red';>Correo ya utilizado en otra cuenta</p>";
        }
        ?>
    </div>
    <div class="form-group">
        <label for="clave">Contraseña: </label>
        <input class="form-control" type="password" name="clave" id="clave" required>
    </div>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>