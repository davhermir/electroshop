<h1>Nuevo Articulo</h1>
<form method="post" action="?action=nuevo_articulo_check" name="f1" enctype="multipart/form-data">
    <div class="form-group">
        <label for="codigo">Codigo:</label>
        <input class="form-control" maxlength="8" name="codigo" id="codigo" pattern="[A-Za-z]{3}[0-9]{1,5}" required><br>
        <?php
        if (isset($codigo_duplicado) && $codigo_duplicado) {
            echo "<p style='color:red;'>Código duplicado</p>";
        } else if (isset($codigo_error) && $codigo_error) {
            echo "<p style='color:red;'>Código incorrecto</p>";
        }
        ?>
    </div>
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input class="form-control" maxlength="40" size="40" name="nombre" id="nombre" required>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" cols="50" rows="5" maxlength="150" required></textarea>
    </div>
    <div class="form-group">
        <label for="categoria">Categoria:</label>
        <select class="form-control" name="categoria" id="categoria">
            <?php
            foreach ($categorias as $cat) { ?>
                <option value="<?= $cat->getCodigo() ?>"><?= $cat->getNombre() ?></option>";
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input class="form-control" type="number" name="precio" id="precio" required>
    </div>
    <div class="form-group">
        <label for="imagen">Imagen:</label>
        <input class="form-control" type="file" name="img" id="img" accept=".jpg, .jpeg, .png" required>
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
        <input class="form-control" type="number" name="descuento" id="descuento">
    </div>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>