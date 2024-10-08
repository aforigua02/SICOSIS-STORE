// Definimos las rutas y los archivos HTML correspondientes 
const routes = {
    '/homepage': '/Sicosis_Store/public/templates/homepage.php',
    '/hombre': '/Sicosis_Store/public/templates/hombre.php',
    '/dama': '/Sicosis_Store/public/templates/dama.php',
    '/nino': '/Sicosis_Store/public/templates/nino.php',
    '/accesorios': '/Sicosis_Store/public/templates/accesorios.php',
    '/calzado': '/Sicosis_Store/public/templates/calzado.php',
    '/carrito': '/Sicosis_Store/public/templates/carrito.php',
    '/favoritos': '/Sicosis_Store/public/templates/favoritos.php',
    '/admin/login': '/Sicosis_Store/admin/login-admin.php',
    '/admin/dashboard': '/Sicosis_Store/admin/dashboard.php',
    '/admin/productos-admin': '/Sicosis_Store/admin/productos-admin.php',
};

// Función para cargar el contenido dinámicamente
function loadContent(path) {
    const contentDiv = document.getElementById('content-principal');
    const route = routes[path] || '/Sicosis_Store/public/templates/404.php'; // Cargar 404 si no existe la ruta

    fetch(route)
    .then(response => response.text())
    .then(html => {
        contentDiv.innerHTML = html;

        // Inicializar el carrusel después de que el contenido haya sido cargado
        document.querySelectorAll('.carousel').forEach(function (carousel) {
            new bootstrap.Carousel(carousel);
        });
    })
    .catch(error => {
        console.error('Error al cargar la vista:', error);
    });
}

// Función para manejar el cambio de ruta sin hash
function navigateTo(path) {
    const route = routes[path] || '/Sicosis_Store/public/templates/404.php'; // Cargar 404 si no existe la ruta
    fetch(route)
        .then(response => response.text())
        .then(html => {
            document.getElementById('content-principal').innerHTML = html;
            // Volver a asociar eventos a los botones después de cargar la vista
            bindFavoriteAndCartEvents(); // Reasocia los eventos
        })
        .catch(error => {
            console.error('Error cargando la vista:', error);
        });
}



// Manejar el evento cuando se navega en el historial
window.addEventListener('popstate', () => {
    loadContent(window.location.pathname.replace('/Sicosis_Store', ''));  // Eliminar el prefijo de la ruta
});

// Cargar la vista inicialen 
window.addEventListener('load', () => {
    loadContent(window.location.pathname.replace('/Sicosis_Store', ''));  // Eliminar el prefijo de la ruta
});

function loadcontentAdmin(path){
    const contentDiv = document.getElementById('contenido-principalAdmin');
    const route = routes[path] || '/Sicosis_Store/public/templates/404.php'; // Cargar 404 si no existe la ruta

    console.log(`Cargando ruta admin: ${route}`); // Depuración

    fetch(route)
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta: ' + response.status);
        }
        return response.text();
    })
    .then(html => {
        contentDiv.innerHTML = html;
    })
    .catch(error => {
        console.error('Error al cargar la vista admin:', error);
        contentDiv.innerHTML = `<p>Error al cargar la página admin: ${error.message}</p>`;
    });
}
