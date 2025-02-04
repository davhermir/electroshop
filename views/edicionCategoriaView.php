<h1>Edición Categoria</h1>
<a href="?action=borrar_categoria&id=<?= $categoria->getCodigo() ?>"><button class="btn btn-success boton boton">Borrar
        Categoría</button></a>
<form method="post" action="?action=edicion_categoria_check" name="f2">
    <div class="form-group">
        <label for="codigo">Codigo:</label>
        <input class="form-control" maxlength="11" size="11" name="codigo" id="codigo"
            value=<?= $categoria->getCodigo() ?> required><br>
        <input hidden name="codigoAnterior" value=<?= $categoria->getCodigo() ?>>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="50" size="50" name="nombre" id="nombre"
            value=<?= $categoria->getNombre() ?> required><br><br>
    </div>
    <div class="form-group">
        <label for="categoriaPadre">Categoria Padre:</label>
        <select class="form-control" name="categoriaPadre" id="categoriaPadre">
            <option value='null'></option>
            <?php
            foreach ($categiasPadre as $cat) {
                if ($cat->getCodigo() !== $categoria->getCodigo()) {
                    $selected = ($cat->getCodigo() == $categoria->getCodpadre()) ? 'selected' : ''; ?>
                    <option value="<?= $cat->getCodigo() ?>" <?= $selected ?>><?= $cat->getNombre() ?></option>
                <?php }
            } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="activo">Activo</label>
        <select class="form-control" name="activo" id="activo" required>
            <?php
            $selectedTrue = $categoria->getActivo() == 1 ? 'selected' : '';
            $selectedFalse = $categoria->getActivo() == 0 ? 'selected' : '';
            ?>
            <option value=1 <?= $selectedTrue ?>>Activo</option>
            <option value=0 <?= $selectedFalse ?>>Inactivo</option>
        </select>
    </div>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>