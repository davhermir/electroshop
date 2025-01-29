<h3>Gestión Categorías</h3>
<a href="?action=nueva_categoria"><button class="btn btn-success">Nueva Categoría</button></a>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Codigo Padre</th>
            <th>Activo</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
        foreach ($menu as $categoriaPadre) {
            echo '<tr>';
            $categoria = $categoriaPadre['categoria'];
            $activo = $categoria->getActivo() == 1 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>';
            echo '<td>' . $categoria->getCodigo() . '</td>';
            echo '<td>' . $categoria->getNombre() . '</td>';
            echo '<td>' . $categoria->getCodpadre() . '</td>';
            echo '<td>' . $activo . '</td>';
            echo '<td><a href="?action=edicion_categoria&id_cat=' . $categoria->getCodigo() . '"><i class="bi bi-pencil"></i></a></td>';
            echo '</tr>';
            if (!empty($categoriaPadre['hijas'])) {

                foreach ($categoriaPadre['hijas'] as $hija) {
                    echo '<tr>';
                    $activo = $hija->getActivo() == 1 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>';
                    echo '<td>' . $hija->getCodigo() . '</td>';
                    ;
                    echo '<td>' . $hija->getNombre() . '</td>';
                    echo '<td>' . $hija->getCodpadre() . '</td>';
                    echo '<td>' . $activo . '</td>';
                    echo '<td><a href="?action=edicion_categoria&id_cat=' . $hija->getCodigo() . '"><i class="bi bi-pencil"></i></a></td>';
                    echo '</tr>';
                }

            }

        }
        if (isset($error_borrado)) {
            echo 'La categoría no se puede borrar, está siendo usada en algún artículo';
        }
        if (isset($cat_padre)) {
            echo 'La categoría no se puede borrar, está siendo usada como categoría padre';
        }
        ?>
    </tbody>
</table>