<h3>Cambiar Datos Cuenta</h3>
<form method="post" action="?action=update_usuario">
    <label for="dni">DNI:</label>
    <input maxlength="9" size="9" name="dni" id="dni" readonly value="<?= htmlspecialchars($usuario->getDni()) ?>"><br><br>
    <label for="nombre">Nombre:</label>
    <input maxlength="30" size="40" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required><br><br>
    <label for="apellidos">Apellidos:</label>
    <input maxlength="75" size="70" name="apellidos" id="apellidos" value="<?= htmlspecialchars($usuario->getApellidos()) ?>"><br><br>
    <label for="direccion">Dirección:</label>
    <input maxlength="50" size="50" name="direccion" id="direccion" value="<?= htmlspecialchars($usuario->getDireccion()) ?>"><br><br>
    <label for="localidad">Localidad:</label>
    <input maxlength="30" size="30" name="localidad" id="localidad" value="<?= htmlspecialchars($usuario->getLocalidad()) ?>"><br><br>
    <label for="provincia">Provincia:</label>
    <input maxlength="30" size="30" name="provincia" id="provincia" value="<?= htmlspecialchars($usuario->getProvincia()) ?>"><br><br>
    <label for="telefono">Teléfono:</label>
    <input type="tel" pattern="[0-9]{9}" maxlength="9" size="9" title="Debes poner 9 números" id="telefono"
        name="telefono" value="<?= htmlspecialchars($usuario->getTelefono()) ?>"><br><br>
    <label for="correo">Correo electrónico:</label>
    <input maxlength="30" size="30" name="correo" id="correo" type="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>"
        required><br><br>
    <?php if (isset($mail_repetido)) {
        echo 'Correo ya utilizado';
    } ?>
    <input type="hidden" name="clave" id="clave" value="<?= htmlspecialchars($usuario->getClave()) ?>"><br><br>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>