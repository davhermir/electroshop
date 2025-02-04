<h1>Nueva Categoria</h1>
<form method="post" action="?action=nueva_categoria_check" name="f2">
    <div class="form-group">
        <label for="codigo">Codigo:</label>
        <input class="form-control" maxlength="11" size="11" name="codigo" id="codigo" required>
        <?php
        if ($codigo_duplicado) {
            echo "<p style='color:red';>Codigo duplicado</p>";
        }
        ?>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="50" size="50" name="nombre" id="nombre" required>
    </div>
    <div class="form-group">
        <label for="categoriaPadre">Categoria Padre:</label>
        <select class="form-control" name="categoriaPadre" id="categoriaPadre">
            <option value='null'></option>
            <?php
            foreach ($categiasPadre as $cat) { ?>
                <option value="<?= $cat->getCodigo() ?>"><?= $cat->getNombre() ?></option>
            <?php } ?>
        </select>
    </div>

    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>