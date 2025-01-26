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
        <label for="apellidos">Apellidos:</label>
        <input maxlength="75" size="75" name="apellidos" id="apellidos" required><br><br>
        <label for="direccion">Dirección:</label>
        <input maxlength="50" size="50" name="direccion" id="direccion" required><br><br>
        <label for="localidad">Localidad:</label>
        <input maxlength="30" size="30" name="localidad" id="localidad" required><br><br>
        <label for="provincia">Provincia:</label>
        <input maxlength="30" size="30" name="provincia" id="provincia" required><br><br>
        <label for="telefono">Teléfono:</label>
        <input type="tel" pattern="[0-9]{9}" maxlength="9" size="9" title ="Debes poner 9 números" id="telefono" name="telefono" required><br><br>
        <label for="correo">Correo electrónico:</label>
        <input maxlength="30" size="30" name="correo" id="correo" type="email" required><br><br>
        <?php
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin') { ?>
           <select name="rol" id="rol">
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
            <option value="Usuario">Usuario</option>
        </select>
        <?php } ?>
        <label for="clave">Contraseña: </label>
        <input type="password" name="clave" id="clave" required><br><br>

        <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
        <input name="Enviar" value="Enviar datos" type="submit"><br>
    </form>