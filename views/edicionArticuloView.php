<h1>Edición Articulo</h1>
<form method="post" action="?action=editar_articulo_check" name="f1" enctype="multipart/form-data">
    <div class="form-group">
        <label for="codigo">Codigo:</label> <input class="form-control" maxlength="8" name="codigo" id="codigo"
            pattern="[A-Za-z]{3}[0-9]{1,5}" value=<?= $articulo->getCodigo() ?> readonly required>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="40" size="40" name="nombre" id="nombre" required
            value=<?= $articulo->getNombre() ?>>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" cols="50" rows="5" maxlength="150"
            required><?= $articulo->getDescripcion() ?></textarea>
    </div>
    <div class="form-group">
        <label for="categoria">Categoria:</label>
        <select class="form-control" name="categoria" id="categoria">
            <?php
            foreach ($categorias as $cat) {
                $selected = ($cat->getCodigo() == $articulo->getCategoria()) ? 'selected' : ''; ?>
                ?>
                <option value="<?= $cat->getCodigo() ?>" <?= $selected ?>><?= $cat->getNombre() ?></option>";
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input class="form-control" type="number" name="precio" id="precio" value=<?= $articulo->getPrecio() ?> required>
    </div>
    <div class="form-group">
        <img class="imgwidth" src="images/<?= $articulo->getImagen() ?>" alt="Imagen del artículo">
        <label for="imagen">Cambiar Imagen:</label>
        <input class="form-control" type="file" name="img" id="img" accept=".jpg, .jpeg, .png">
        <input type="hidden" name="imagenAnterior" value=<?= $articulo->getImagen() ?>>
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
        </p>
    </div>
    <div class="form-group">
        <label for="descuento">Descuento:</label>
        <input class="form-control" type="number" name="descuento" id="descuento" value=<?= $articulo->getDescuento() ?>
            required>
    </div>
    <div class="form-group">
        <label for="activo">Activo</label>
        <select class="form-control" name="activo" id="activo" required>
            <?php
            $selectedTrue = $articulo->getActivo() == 1 ? 'selected' : '';
            $selectedFalse = $articulo->getActivo() == 0 ? 'selected' : '';
            ?>
            <option value=1 <?= $selectedTrue ?>>Activo</option>
            <option value=0 <?= $selectedFalse ?>>Inactivo</option>
        </select>
    </div>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>