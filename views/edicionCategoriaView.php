<h1>Edición Categoria</h1>
<a href="?action=borrar_categoria&id=<?=$categoria->getCodigo()?>"><button>Borrar Categoría</button></a>
<form method="post" action="?action=edicion_categoria_check" name="f2">
    <label for="codigo">Codigo:</label> <input maxlength="11" size="11" name="codigo" id="codigo" value=<?=$categoria->getCodigo()?> onlyread required><br>
    <?php
    ?>
    <br>
    <label for="nombre">Nombre:</label>
    <input maxlength="50" size="50" name="nombre" id="nombre" value=<?=$categoria->getNombre()?> required><br><br>

    <label for="categoriaPadre">Categoria Padre:</label>
    <select name="categoriaPadre" id="categoriaPadre">
        <option value='null'></option>
        <?php
        foreach ($categiasPadre as $cat) { 
            if($cat->getCodigo() !== $categoria->getCodigo()){
            $selected = ($cat->getCodigo() == $categoria->getCodpadre()) ? 'selected' : ''; ?>
            <option value="<?= $cat->getCodigo() ?>" <?= $selected ?>><?= $cat->getNombre() ?></option>
        <?php }} ?>
    </select>
    <br><br>

    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>