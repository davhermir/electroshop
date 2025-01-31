<h3>Cambiar Datos Cuenta</h3>
<form method="post" action="?action=update_usuario">
    <div class="form-group">
        <label for="dni">DNI:</label>
        <input class="form-control" maxlength="9" size="9" name="dni" id="dni" readonly
            value="<?= htmlspecialchars($usuario->getDni()) ?>">
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="30" size="40" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>"
            required>
    </div>
    <div class="form-group">
        <label for="apellidos">Apellidos:</label>
        <input class="form-control" maxlength="75" size="70" name="apellidos" id="apellidos"
            value="<?= htmlspecialchars($usuario->getApellidos()) ?>">
    </div>
    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input class="form-control" maxlength="50" size="50" name="direccion" id="direccion"
            value="<?= htmlspecialchars($usuario->getDireccion()) ?>">
    </div>
    <div class="form-group">
        <label for="localidad">Localidad:</label>
        <input class="form-control" maxlength="30" size="30" name="localidad" id="localidad"
            value="<?= htmlspecialchars($usuario->getLocalidad()) ?>">
    </div>
    <div class="form-group">
        <label for="provincia">Provincia:</label>
        <input class="form-control" maxlength="30" size="30" name="provincia" id="provincia"
            value="<?= htmlspecialchars($usuario->getProvincia()) ?>">
    </div>
    <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input class="form-control" type="tel" pattern="[0-9]{9}" maxlength="9" size="9" title="Debes poner 9 números" id="telefono"
            name="telefono" value="<?= htmlspecialchars($usuario->getTelefono()) ?>">
    </div>
    <div class="form-group">
        <label for="correo">Correo electrónico:</label>
        <input class="form-control" maxlength="30" size="30" name="correo" id="correo" type="email"
            value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>
        <?php if (isset($mail_repetido)) {
            echo 'Correo ya utilizado';
        } ?>
    </div>
    <input type="hidden" name="clave" id="clave" value="<?= htmlspecialchars($usuario->getClave()) ?>">
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>