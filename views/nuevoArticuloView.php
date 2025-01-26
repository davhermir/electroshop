<h1>Nuevo Articulo</h1>
    <form method="post" action="?action=nuevo_articulo_check" name="f1" enctype="multipart/form-data">
        <label for="codigo">Codigo:</label> <input maxlength="8" name="codigo" id="codigo" pattern="[A-Za-z]{3}[0-9]{1,5}" required><br>
        <?php
        if (isset($codigo_duplicado) && $codigo_duplicado) {
            echo "<p style='color:red;'>Código duplicado</p>";
        } else if (isset($codigo_error) && $codigo_error) {
            echo "<p style='color:red;'>Código incorrecto</p>";
        }
        ?>
        <br>
        <label for="nombre">Nombre:</label>
        <input maxlength="40" size="40" name="nombre" id="nombre" required><br><br>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" cols="50" rows="5" maxlength="150" required></textarea><br><br>
        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria">
        <?php
        foreach ($categorias as $cat) {?>
            <option value="<?=$cat->getCodigo()?>"><?=$cat->getNombre()?></option>";
        <?php } ?>
        </select>
        <br><br>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" required><br><br>
        <label for="imagen">Imagen:</label>
        <input type="file" name="img" id="img" accept=".jpg, .jpeg, .png" required>
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
        <input type="number" name="descuento" id="descuento" required><br><br>
        <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
        <input name="Enviar" value="Enviar datos" type="submit"><br>
    </form>