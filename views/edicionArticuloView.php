<h1>Nuevo Articulo</h1>
    <form method="post" action="?action=editar_articulo_check" name="f1" enctype="multipart/form-data">
        <label for="codigo">Codigo:</label> <input maxlength="8" name="codigo" id="codigo" pattern="[A-Za-z]{3}[0-9]{1,5}"
        value=<?=$articulo->getCodigo()?> readonly required><br>
        <br>
        <label for="nombre">Nombre:</label>
        <input maxlength="40" size="40" name="nombre" id="nombre" required value=<?=$articulo->getNombre()?>><br><br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" cols="50" rows="5" maxlength="150" required><?=$articulo->getDescripcion()?></textarea><br><br>
        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria">
        <?php
        foreach ($categorias as $cat) {
            $selected = ($cat->getCodigo() == $articulo->getCategoria()) ? 'selected' : ''; ?>
            ?>
            <option value="<?=$cat->getCodigo()?>" <?= $selected ?>><?=$cat->getNombre()?></option>";
        <?php } ?>
        </select>
        <br><br>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" value=<?=$articulo->getPrecio()?> required><br><br>
        <img class="imgwidth" src="Images/<?=$articulo->getImagen() ?>" alt="Imagen del artículo"><br>
        <label for="imagen">Cambiar Imagen:</label>
        <input type="file" name="img" id="img" accept=".jpg, .jpeg, .png">
        <input type="hidden" name="imagenAnterior" value=<?=$articulo->getImagen()?>>
        
        <p class="error">
            <?php
            if (isset($emptyFieldsError) && $emptyFieldsError) {
                echo "*Rellena todos los campos";
            } else if (isset($fileError) && $fileError) {
                echo "*Error en el tipo de archivo";
            } else if (isset($fileSaveError) && $fileSaveError) {
                echo "*Error al guardar el archivo";
            }
            ?>
        </p><br><br>
        <label for="descuento">Descuento:</label>
        <input type="number" name="descuento" id="descuento" value=<?=$articulo->getDescuento()?> required><br><br>
        <label for="activo">Activo</label>
    <select name="activo" id="activo" required>
        <?php
        $selectedTrue = $articulo->getActivo()==1?'selected':'';
        $selectedFalse = $articulo->getActivo()==0?'selected':'';
        ?>
        <option value=1 <?= $selectedTrue ?>>Activo</option>
        <option value=0 <?= $selectedFalse ?>>Inactivo</option>
    </select><br><br>
        <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
        <input name="Enviar" value="Enviar datos" type="submit"><br>
    </form>