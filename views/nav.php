<div class="flex">
    <nav class="nav">
        <?php
        foreach ($menu as $categoriaPadre) {
            $categoria = $categoriaPadre['categoria'];
            echo '<ul class="menu-nav">';
            echo '<li class="menu-item">';
            echo '<p>' . $categoria->getNombre();
            echo '<span class="toggle-arrow"><i class="bi bi-caret-down"></i></span></p>';
            echo '<ul class="submenu">';
            echo '<li><a href="?action=mostrar_articulos&cat=' . $categoria->getCodigo() . '" class="' . ($_SERVER['REQUEST_URI'] == '/?action=mostrar_articulos&cat=' . $categoria->getCodigo() ? 'active' : '') . '">';
            echo 'Ver todos';
            echo '</a></li>';
            if (!empty($categoriaPadre['hijas'])) {
                foreach ($categoriaPadre['hijas'] as $hija) {
                    echo '<li><a href="?action=mostrar_articulos&cat=' . $hija->getCodigo() . '" class="' . ($_SERVER['REQUEST_URI'] == '/?action=mostrar_articulos&cat=' . $hija->getCodigo() ? 'active' : '') . '">';
                    echo $hija->getNombre();
                    echo '</a></li>';
                }
            }
            echo '</ul>';
            echo '</li>';
            echo '</ul>';
        }
        ?>
    </nav>
    <div class="content">