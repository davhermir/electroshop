<h3>Gestión Usuarios</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Rol</th>
            <th>Activo</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php
        foreach ($users as $user) {
            if($user->getDni() !=$_SESSION['dni']){
            echo '<tr>';
            $activo = $user->getActivo() == 1 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>';
            echo '<td>' . $user->getDni() . '</td>';
            echo '<td>' . $user->getNombre() . '</td>';
            echo '<td>' . $user->getRol() . '</td>';
            echo '<td>' . $activo . '</td>';
            echo '<td><a href="?action=gestion_user&dni=' . $user->getDni() . '"><i class="bi bi-pencil"></i></a></td>';
            echo '</tr>';
            }
        }
        $total_paginas;
        $num_total_registros;
        if ($total_paginas > 1) {
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i) {
                    echo $pagina . " ";
                } else {
                    echo "<a href='/?action=gestion_usuarios&pagina=" . $i . "'>" . $i . "</a>  ";
                }
            }
        }
        echo "  | Paginas:" . $total_paginas . "  | Total elementos: " . $num_total_registros;
        ?>
    </tbody>
</table>