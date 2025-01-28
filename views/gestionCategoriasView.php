<h3>Gestión Categorías</h3>
<a href="?action=nueva_categoria"><button>Nueva Categoría</button></a>
<?php
        foreach ($menu as $categoriaPadre) {
            $categoria = $categoriaPadre['categoria'];
            echo '<ul>';
            echo '<li>';
            echo '<p>' . $categoria->getNombre() . '<a href="?action=edicion_categoria&id_cat='. $categoria->getCodigo() . '"><i class="bi bi-pencil"></i></a></p>';
            if (!empty($categoriaPadre['hijas'])) {
                echo '<ul>';
                foreach ($categoriaPadre['hijas'] as $hija) {
                    echo '<li><p>' . $hija->getNombre();
                    echo ' <a href="?action=edicion_categoria&id_cat='. $hija->getCodigo() . '"><i class="bi bi-pencil"></i></a></p></li>';
                }
                echo '</ul>';
            }
            echo '</li>';
            echo '</ul>';
        }
        if(isset($error_borrado)){
            echo 'La categoría no se puede borrar, está siendo usada en algún artículo';
        }
        if(isset($cat_padre)){
            echo 'La categoría no se puede borrar, está siendo usada como categoría padre';
        }
        ?>