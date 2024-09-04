// Definimos las rutas y los archivos HTML correspondientes
const routes = {
    '/homepage': 'public/templates/homepage.html',
    '/hombre': 'public/templates/hombre.html',
    '/dama': 'public/templates/dama.html',
    '/nino': 'public/templates/nino.html',
    '/accesorios': 'public/templates/accesorios.html',
    '/calzado': 'public/templates/calzado.html',
    '/carrito': 'public/templates/carrito.html',
    '/favoritos': 'public/templates/favoritos.html',
};

// Función para cargar el contenido dinámicamente
function loadContent(path) {
    const contentDiv = document.getElementById('content');
    const route = routes[path] || 'templates/404.html'; // Cargar 404 si no existe la ruta

    fetch(route)
    .then(response => response.text())
    .then(html => {
        contentDiv.innerHTML = html;

        document.querySelectorAll('.carousel').forEach(function(carousel) {
            new bootstrap.Carousel(carousel);
        });
    })
    .catch(error => {
        console.error('Error al cargar la vista:', error);
    });
}

// Función para manejar el cambio de hash
function onRouteChange() {
    const path = window.location.hash.slice(1) || '/homepage'; // Obtenemos la ruta del hash
    loadContent(path); // Cargar la vista correspondiente
}

// Detectar cuando el hash cambia
window.addEventListener('hashchange', onRouteChange);

// Cargar la vista inicial
window.addEventListener('load', onRouteChange);
