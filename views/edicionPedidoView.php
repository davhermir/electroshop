<h1>Edición Pedido</h1>
<form method="post" action="?action=edicion_pedido_check" name="f2">
    <div class="form-group">
        <label for="id">ID Pedido:</label>
        <input class="form-control" name="id" id="id"
            value=<?= $pedido->getIdPedido() ?> readonly><br>
    </div>
    <div class="form-group">
        <label for="estado">Estado</label>
        <select class="form-control" name="estado" id="estado" required>
            <?php
            $selected1="";
            $selected2="";
            $selected3="";
            switch ($pedido->getEstado()) {
                case "1":
                $selected1='selected';
                break;
                case "2";
                $selected2='selected';
                break;
                case "3":
                $selected3='selected';
                break;
            };
            ?>
            <option value=1 <?= $selected1 ?>>En Preparación</option>
            <option value=2 <?= $selected2 ?>>Enviado</option>
            <option value=3 <?= $selected3 ?>>Finalizado</option>
        </select>
    </div>
    <div class="form-group">
        <label for="activo">Activo</label>
        <select class="form-control" name="activo" id="activo" required>
            <?php
            $selectedTrue = $pedido->getActivo() == 1 ? 'selected' : '';
            $selectedFalse = $pedido->getActivo() == 0 ? 'selected' : '';
            ?>
            <option value=1 <?= $selectedTrue ?>>Activo</option>
            <option value=0 <?= $selectedFalse ?>>Inactivo</option>
        </select>
    </div>
    <input name="Borrar" value="Vaciar campos" type="reset">&nbsp;&nbsp;&nbsp;
    <input name="Enviar" value="Enviar datos" type="submit"><br>
</form>