// Definimos las rutas y los archivos HTML correspondientes
const routes = {
    '/': 'homepage.html',
    '/hombre': 'hombre.html',
    '/dama': 'dama.html',
    '/niño': 'niño.html',
    '/accesorios': 'accesorios.html',
    '/carrito': 'carrito.html',
    '/favoritos': 'favoritos.html',
};

// Función para cargar el contenido dinámicamente
function loadContent(path) {
    const contentDiv = document.getElementById('content');
    
    // Buscar la ruta en el objeto routes
    const route = routes[path] || '404.html'; // Cargar 404 si no existe la ruta
    
    // Fetch para cargar el archivo HTML correspondiente
    fetch(`templates/${route}`)
    .then(response => response.text())
    .then(html => {
        contentDiv.innerHTML = html;
    })
    .catch(error => {
        console.error('Error al cargar la vista:', error);
    });
}

// Función para manejar el cambio de hash
function onRouteChange() {
    const path = window.location.hash.slice(1) || '/'; // Obtenemos la ruta del hash
    loadContent(path); // Cargar la vista correspondiente
}

// Detectar cuando el hash cambia
window.addEventListener('hashchange', onRouteChange);

// Cargar la vista inicial
window.addEventListener('load', onRouteChange);
