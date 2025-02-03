<header class="header">
    <div>
        <img class="cabeceraimg" src="sources/img1.png" alt="ElectroShop">
        <nav class="menu-left header-style">
            <div class="header-links">
                <a href="?action=mostrar_articulos" class="link margin-right">Inicio</a>
                <a href="acerca.php" class="link margin-right">Acerca de</a>
                <a href="contacto.php" class="link margin-right">Contacto</a>
                <?php if (isset($dni)) { ?>
                    <a href="?action=ver_pedidos" class="link margin-right">Pedidos</a>
                    <a href="?action=cuenta" class="link margin-right">Cuenta</a>
                <?php }
                if (isset($admin) || isset($editor)) { ?>
                    <a href="?action=gestion_categorias" class="link margin-right">Categorias</a>
                <?php }
                if (isset($admin)) { ?>
                    <a href="?action=gestion_usuarios" class="link margin-right">Usuarios</a>
                <?php } ?>
            </div>
            <div>
                <form method="get" action="" name="buscarArt">
                    <input type="hidden" name="action" value="buscar_articulo">
                    <div class="flex-row">
                        <label for="nombre"></label>
                        <input type="text" name="nombre" id="nombre" placeholder="Buscar Articulo..."
                            aria-label="Buscar Articulo...">
                        <button type="submit" class="btn btn-default"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</header>