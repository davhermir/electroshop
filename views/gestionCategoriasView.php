<?php
        foreach ($menu as $categoriaPadre) {
            $categoria = $categoriaPadre['categoria'];
            echo '<ul>';
            echo '<li>';
            echo '<p>' . $categoria->getNombre();
            echo '<ul class="submenu">';
            if (!empty($categoriaPadre['hijas'])) {
                foreach ($categoriaPadre['hijas'] as $hija) {
                    echo '<li>echo $hija->getNombre();';
                    echo '</li>';
                }
            }
            echo '</ul>';
            echo '</li>';
            echo '</ul>';
        }
        ?>