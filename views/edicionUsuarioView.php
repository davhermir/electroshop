<?php
$selectOptions=['admin','editor','usuario'];
?>
<h3>Cambiar Datos Usuario</h3>
<form method="post" action="?action=update_usuario">
    <label for="dni">DNI:</label>
    <input maxlength="9" size="9" name="dni" id="dni" readonly
        value="<?= htmlspecialchars($usuario->getDni()) ?>"><br><br>
    <label for="nombre">Nombre:</label>
    <input maxlength="30" size="40" readonly name="nombre" id="nombre"
        value="<?= htmlspecialchars($usuario->getNombre()) ?>" required><br><br>

    <label for="rol">Rol:</label>
    <select name="rol" id="rol">
    <?php
        foreach ($selectOptions as $option) {
            $selected = ($option == $usuario->getRol()) ? 'selected' : ''; ?>
            <option value="<?=$option?>" <?= $selected ?>><?=$option?></option>";
            <?php } ?>
    </select>
    <label for="activo">Activo</label>
    <select name="activo" id="activo" required>
        <?php
        $selectedTrue = $usuario->getActivo()==1?'selected':'';
        $selectedFalse = $usuario->getActivo()==0?'selected':'';
        ?>
        <option value=1 <?= $selectedTrue ?>>Activo</option>
        <option value=0 <?= $selectedFalse ?>>Inactivo</option>
    </select>
    <br><br>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>