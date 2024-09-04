// Definimos las rutas y los archivos HTML correspondientes
const routes = {
    '/homepage': '/Sicosis_Store/public/templates/homepage.html',
    '/hombre': '/Sicosis_Store/public/templates/hombre.html',
    '/dama': '/Sicosis_Store/public/templates/dama.html',
    '/nino': '/Sicosis_Store/public/templates/nino.html',
    '/accesorios': '/Sicosis_Store/public/templates/accesorios.html',
    '/calzado': '/Sicosis_Store/public/templates/calzado.html',
    '/carrito': '/Sicosis_Store/public/templates/carrito.html',
    '/favoritos': '/Sicosis_Store/public/templates/favoritos.html',
};



// Función para cargar el contenido dinámicamente
function loadContent(path) {
    const contentDiv = document.getElementById('content');
    const route = routes[path] || 'public/templates/404.html'; // Cargar 404 si no existe la ruta

    fetch(route)
    .then(response => response.text())
    .then(html => {
        contentDiv.innerHTML = html;
    })
    .catch(error => {
        console.error('Error al cargar la vista:', error);
    });
}

// Función para manejar el cambio de ruta sin hash
function navigateTo(path) {
    window.history.pushState({}, path, window.location.origin + '/Sicosis_Store/homepage' + path);
    loadContent(path);
}
// Manejar el evento cuando se navega en el historial
window.addEventListener('popstate', () => {
    loadContent(window.location.pathname.replace('/Sicosis_Store/homepage', ''));  // Eliminar el prefijo de la ruta
});

// Cargar la vista inicial
window.addEventListener('load', () => {
    loadContent(window.location.pathname.replace('/Sicosis_Store/homepage', ''));  // Eliminar el prefijo de la ruta
});