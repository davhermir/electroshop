<h1>Nuevo Cliente</h1>
<form method="post" action="?action=nueva_categoria_check" name="f2">
    <label for="codigo">Codigo:</label> <input maxlength="11" size="11" name="codigo" id="codigo" required><br>
    <?php
    if ($codigo_duplicado) {
        echo "<p style='color:red';>Codigo duplicado</p>";
    }
    ?>
    <br>
    <label for="nombre">Nombre:</label>
    <input maxlength="50" size="50" name="nombre" id="nombre" required><br><br>

    <label for="categoriaPadre">Categoria Padre:</label>
    <select name="categoriaPadre" id="categoriaPadre">
        <option value=null></option>
        <?php
        foreach ($categiasPadre as $cat) { ?>
            <option value="<?= $cat->getCodigo() ?>"><?= $cat->getNombre() ?></option>
        <?php } ?>
    </select>
    <br><br>

    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>