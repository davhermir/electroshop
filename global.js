document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item');

    menuItems.forEach(item => {
        const submenu = item.querySelector('.submenu');
        const toggleArrow = item.querySelector('.toggle-arrow');

        // Verifica si el submenú debe estar abierto al recargar la página
        if (localStorage.getItem(item.querySelector('p').textContent) === 'open') {
            item.classList.add('open');
        }

        // Añadir el evento de clic en el elemento padre
        item.querySelector('p').addEventListener('click', function(event) {
            event.preventDefault();  // Evitar que el enlace redirija al hacer clic

            // Alternar la clase 'open' para abrir/cerrar el submenú
            item.classList.toggle('open');

            // Guardar el estado del submenú en localStorage
            if (item.classList.contains('open')) {
                localStorage.setItem(item.querySelector('p').textContent, 'open');
            } else {
                localStorage.removeItem(item.querySelector('p').textContent);
            }
        });
    });
});