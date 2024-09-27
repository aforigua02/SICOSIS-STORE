// Manejo del registro de usuario
document.getElementById("registerForm").addEventListener("submit", registerUser);

function registerUser(event) {
    event.preventDefault();
    const userName = document.getElementById("userName").value;
    const userApellido = document.getElementById("userApellido").value;
    const userEmail = document.getElementById("userEmail").value;
    const userPassword = document.getElementById("userPassword").value;

    if (userName.trim() === "" || userApellido.trim() === "" || userEmail.trim() === "" || userPassword.trim() === "") {
        alert("Por favor, complete todos los campos");
        return;
    }

    const userData = { userName, userApellido, userEmail, userPassword };

    fetch('http://localhost/Sicosis_Store/model/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registro exitoso. Redirigiendo...');
            window.location.href = '/Sicosis_Store/homepage';
        } else {
            alert("Error en el registro: " + data.message);
        }
    })
    .catch(error => {
        console.error("Hubo un problema con la solicitud de registro", error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const productModalElement = document.getElementById('productModal');

    // Verifica que el modal esté en el DOM
    if (!productModalElement) {
        console.error("El modal no se encontró en el DOM.");
        return;
    }

    // Instancia el modal de Bootstrap 5
    const productModal = new bootstrap.Modal(productModalElement);

    // Escucha el evento para mostrar el modal con los datos correctos
    productModalElement.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Obtener los datos del botón que activó el modal
        const nombre = button.getAttribute('data-nombre');
        const precio = button.getAttribute('data-precio');
        const talla = button.getAttribute('data-talla');
        const color = button.getAttribute('data-color');
        const url = button.getAttribute('data-url');

        // Llenar los elementos del modal con los datos del producto
        document.getElementById('modalProductImage').src = url;
        document.getElementById('modalProductName').textContent = nombre;
        document.getElementById('modalProductPrice').textContent = precio;
        document.getElementById('modalProductTalla').textContent = "Talla: " + talla;
        document.getElementById('modalProductColor').textContent = "Color: " + color;
    });
});












//----------------------- Manejo de favoritos---------------------------------------

const btnsFavorite = document.querySelectorAll('.heart-icon');
const containerListFavorites = document.querySelector('.container-list-favorites');
const listFavorites = document.querySelector('.list-favorites');
const counterFavorites = document.querySelector('.counter-favorite');

let favorites = [];

// Función para verificar si el usuario está logueado
const isLoggedIn = () => {
    return sessionStorage.getItem('user_id') !== null;
};

// Función para actualizar los favoritos en sessionStorage
const updateFavoritesInSessionStorage = () => {
    const userId = sessionStorage.getItem('user_id');
    sessionStorage.setItem(`favorites_${userId}`, JSON.stringify(favorites));
};

// Función para cargar los favoritos desde sessionStorage
const loadFavoritesFromSessionStorage = () => {
    const userId = sessionStorage.getItem('user_id');
    const storedFavorites = sessionStorage.getItem(`favorites_${userId}`);
    if (storedFavorites) {
        favorites = JSON.parse(storedFavorites);
        showHTML(); // Actualiza la interfaz con los favoritos cargados
    }
};


// Función para manejar los clics en los iconos de corazón
function toggleHeart(event, productId) {
    event.preventDefault();

    if (!isLoggedIn()) {
        alert("Debes iniciar sesión para agregar productos a favoritos.");
        const loginModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
        loginModal.show(); // Mostrar el modal de inicio de sesión
        return;
    }

    const heartIcon = document.getElementById(`heart-icon-${productId}`);
    const heartFillIcon = document.getElementById(`heart-fill-icon-${productId}`);

    // Selección de elementos sin colapso
    const card = heartIcon.closest('.card-small');
    const title = card.querySelector('.card-title').textContent; // Captura el título
    const price = card.querySelector('.list-group-item').textContent; // Captura el precio
    const imageUrl = card.querySelector('img').src; // Captura la URL de la imagen

    if (heartFillIcon.style.display === "none") {
        heartIcon.style.display = "none"; // Ocultar corazón vacío
        heartFillIcon.style.display = "inline"; // Mostrar corazón lleno

        // Verifica si el producto no está ya en favoritos
        if (!favorites.some(fav => fav.id === productId)) {
            favorites.push({
                id: productId,
                title: title,
                price: price,
                image: imageUrl // Agrega la URL de la imagen
            });
            updateFavoritesInSessionStorage();
        }
    } else {
        heartIcon.style.display = "inline"; // Mostrar corazón vacío
        heartFillIcon.style.display = "none"; // Ocultar corazón lleno

        // Eliminar de favoritos
        favorites = favorites.filter(fav => fav.id !== productId);
        updateFavoritesInSessionStorage();
    }

    showHTML();
}


// Función para mostrar el estado de favoritos en productos
const showHTML = () => {
    btnsFavorite.forEach(button => {
        const productId = button.id.split('-')[1]; // Extrae el ID del botón
        const isFavorite = favorites.some(favorite => favorite.id === productId); // Verifica si es favorito

        // Marcar el corazón como lleno o vacío
        const heartIcon = document.getElementById(`heart-icon-${productId}`);
        const heartFillIcon = document.getElementById(`heart-fill-icon-${productId}`);

        if (isFavorite) {
            heartIcon.style.display = "none"; // Ocultar corazón vacío
            heartFillIcon.style.display = "inline"; // Mostrar corazón lleno
        } else {
            heartIcon.style.display = "inline"; // Mostrar corazón vacío
            heartFillIcon.style.display = "none"; // Ocultar corazón lleno
        }
    });

    updateFavoriteMenu(); // Actualiza el menú de favoritos
};



// Función para actualizar el menú de favoritos
const updateFavoriteMenu = () => {
    listFavorites.innerHTML = '';  // Limpiar la lista antes de actualizar

    favorites.forEach(fav => {
        const favoriteCard = document.createElement('div');
        favoriteCard.classList.add('card-favorite');

        // Crear elemento para la imagen
        const imageElement = document.createElement('img');
        imageElement.src = fav.image;
        imageElement.classList.add('favorite-image');  
        favoriteCard.appendChild(imageElement);

        // Crear contenedor para el nombre y el precio
        const infoContainer = document.createElement('div');
        infoContainer.classList.add('info-container');

        // Crear y añadir el título del producto
        const titleElement = document.createElement('p');
        titleElement.classList.add('title');
        titleElement.textContent = fav.title;
        infoContainer.appendChild(titleElement);

        // Crear y añadir el precio del producto
        const priceElement = document.createElement('p');
        priceElement.classList.add('price');
        priceElement.textContent = fav.price;
        infoContainer.appendChild(priceElement);

        // Añadir el contenedor de info (nombre y precio) a la tarjeta
        favoriteCard.appendChild(infoContainer);

        // Crear un contenedor para los íconos de caneca y carrito
        const iconContainer = document.createElement('div');
        iconContainer.classList.add('icon-container');

        // Crear el botón de eliminar con ícono de caneca
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-favorite-btn');

        const trashIcon = document.createElement('i');
        trashIcon.classList.add('fas', 'fa-trash');  // Ícono de Font Awesome para la caneca
        deleteButton.appendChild(trashIcon);

        // Evento para eliminar el producto de favoritos
        deleteButton.addEventListener('click', () => {
            // Elimina el producto de favoritos
            favorites = favorites.filter(f => f.id !== fav.id);
            updateFavoritesInSessionStorage();  // Actualiza sessionStorage

            // Lógica para cambiar el corazón a vacío
            const heartIcon = document.getElementById(`heart-icon-${fav.id}`);
            const heartFillIcon = document.getElementById(`heart-fill-icon-${fav.id}`);
            if (heartIcon && heartFillIcon) {
                heartIcon.style.display = "inline"; // Muestra el corazón vacío
                heartFillIcon.style.display = "none"; // Oculta el corazón lleno
            }

            showHTML();  // Actualiza la vista
        });

        // Agregar el botón de eliminar al contenedor de íconos
        iconContainer.appendChild(deleteButton);

        // Crear el botón de carrito de compras
        // Crear el botón de carrito de compras
        const cartButton = document.createElement('button');
        cartButton.classList.add('add-cart-btn');

        const cartIcon = document.createElement('i');
        cartIcon.classList.add('fas', 'fa-shopping-cart');  // Ícono de Font Awesome para carrito
        cartButton.appendChild(cartIcon);

        // Evento para agregar el producto al carrito
        cartButton.addEventListener('click', (event) => {
            // Usa la función addToCart con el ID del producto
            addToCart(event, fav.id);  // fav.id representa el ID del producto en la lista de favoritos
        });

        // Agregar el botón del carrito al contenedor de íconos
        iconContainer.appendChild(cartButton);


        // Agregar el contenedor de íconos a la tarjeta
        favoriteCard.appendChild(iconContainer);

        // Añadir el producto favorito a la lista
        listFavorites.appendChild(favoriteCard);
    });

    counterFavorites.textContent = favorites.length;  // Actualizar el contador de favoritos
};

// Manejo del evento para los botones de favoritos
btnsFavorite.forEach(button => {
    button.addEventListener('click', e => {
        const card = e.target.closest('.collapse');
        if (card) {
            const productId = card.dataset.id; // Obtiene el ID del producto
            toggleHeart(e, productId);
            containerListFavorites.style.display = 'block'; // Muestra el panel de favoritos
        }
    });
});

// Mostrar/Ocultar el panel de favoritos
document.querySelector('#button-header-favorite').addEventListener('click', () => {
    containerListFavorites.classList.toggle('show');
    containerListFavorites.style.display = containerListFavorites.classList.contains('show') ? 'block' : 'none';
});

document.querySelector('#btn-close').addEventListener('click', () => {
    containerListFavorites.classList.remove('show');
    containerListFavorites.style.display = 'none'; // Ocultar el panel
});

// Cargar favoritos al iniciar
loadFavoritesFromSessionStorage();

// Manejo del inicio de sesión
document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita que el formulario se envíe por defecto

    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginpassword").value;

    if (email === "" || password === "") {
        alert("Por favor, completa ambos campos.");
        return;
    }

    const formData = new FormData();
    formData.append("loginEmail", email);
    formData.append("loginpassword", password);

    // Enviar solicitud al servidor
    fetch("/Sicosis_Store/model/login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.success) {
                sessionStorage.setItem('user_id', jsonData.userId); // Guarda el ID del usuario
                alert("Has iniciado sesión correctamente");
                const loginModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle'));
                loginModal.hide(); // Cierra el modal

                // Cargar los favoritos del usuario y actualizar el UI
                loadFavoritesFromSessionStorage();  // Asegúrate de llamar a esta función

                window.location.href = "/Sicosis_Store/homepage"; // Redirigir si es exitoso
            } else {
                alert("Error en el inicio de sesión: " + jsonData.message);
            }
        } catch (error) {
            console.error("Error al parsear JSON:", error);
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});


// Cargar favoritos al iniciar
loadFavoritesFromSessionStorage();

//-----------------------------CARRITO DE COMPRAS-------------------------------

// Manejo del carrito
const btnsCart = document.querySelectorAll('.cart-icon');
const containerListCart = document.querySelector('.container-list-cart'); // Panel para carrito
const listCart = document.querySelector('.list-cart');
const counterCart = document.querySelector('.counter-cart'); // Contador para el carrito
const cartTotal = document.querySelector('#cart-total'); // Total del carrito

let cart = [];

// Función para actualizar el carrito en sessionStorage
const updateCartInSessionStorage = () => {
    const userId = sessionStorage.getItem('user_id');
    sessionStorage.setItem(`cart_${userId}`, JSON.stringify(cart));
};

// Función para cargar los productos del carrito desde sessionStorage
const loadCartFromSessionStorage = () => {
    const userId = sessionStorage.getItem('user_id');
    const storedCart = sessionStorage.getItem(`cart_${userId}`);
    if (storedCart) {
        cart = JSON.parse(storedCart);
        showCartHTML();
    }
};

// Función para manejar los clics en los iconos de carrito
function addToCart(event, productId) {
    event.preventDefault();

    if (!isLoggedIn()) {
        alert("Debes iniciar sesión para agregar productos al carrito.");
        const loginModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
        loginModal.show(); // Mostrar el modal de inicio de sesión
        return;
    }

    const cartIcon = document.getElementById(`cart-${productId}`);
    
    // Selección de elementos sin colapso
    const card = cartIcon.closest('.card-small');
    const title = card.querySelector('.card-title').textContent;
    const priceText = card.querySelector('.list-group-item').textContent;
    
    // Eliminar símbolos de moneda y el texto 'COP', y convertir a número
    const price = parseFloat(priceText.replace(/[^0-9]/g, '')); // Elimina todo lo que no sea dígito
    const imageUrl = card.querySelector('img').src;

    // Verificar si el producto ya está en el carrito
    if (!cart.some(item => item.id === productId)) {
        cart.push({
            id: productId,
            title: title,
            price: price, // Almacenar el precio como número
            image: imageUrl
        });
        updateCartInSessionStorage();
        alert(`${title} ha sido agregado al carrito.`);
    } else {
        alert('Este producto ya está en el carrito.');
    }

    showCartHTML(); // Actualiza el panel del carrito
}




// Función para mostrar los productos del carrito
// Función para mostrar los productos del carrito
const showCartHTML = () => {
    // Limpiar el panel de carrito
    listCart.innerHTML = ''; 

    // Formateador de moneda (COP)
    const formatCurrency = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0, // No mostrar decimales
    });

    // Inicializar la variable del total del carrito
    let totalCart = 0;

    // Verificar si hay productos en el carrito
    cart.forEach(item => {
        // Seleccionar la tarjeta del producto en el carrito por el ID del producto
        const cartItem = document.getElementById(`cart-item-${item.id}`);
        
        // Formatear el precio del producto
        const formattedPrice = formatCurrency.format(item.price);

        // Sumar el precio del producto al total del carrito
        totalCart += item.price;

        // Verificar si el producto ya está en el carrito
        if (cartItem) {
            // Actualizar el título y el precio del producto
            const titleElement = cartItem.querySelector('.title');
            const priceElement = cartItem.querySelector('.price');
            
            titleElement.textContent = item.title;
            priceElement.textContent = `${formattedPrice} COP`; // Agregar el "COP" al final del precio formateado
        } else {
            // Si no existe, agregar un nuevo elemento al carrito
            const cartItemHTML = `
                <div class="card-cart" id="cart-item-${item.id}">
                    <img src="${item.image}" alt="${item.title}" class="cart-image">
                    <div class="info-cart">
                        <p class="title">${item.title}</p>
                        <p class="price">${formattedPrice} COP</p> <!-- Usar el precio formateado con "COP" -->
                    </div>
                    <div class="icon-container">
                        <button class="delete-cart-btn" onclick="removeFromCart('${item.id}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            listCart.innerHTML += cartItemHTML; // Agregar el nuevo producto al panel del carrito
        }
    });

    // Actualizar el contador del carrito
    counterCart.textContent = cart.length;

    // Verificar si no hay productos en el carrito
    if (cart.length === 0) {
        listCart.innerHTML = '<p>No hay productos en el carrito.</p>';
    }

    // Formatear y mostrar el total del carrito con "COP"
    const formattedTotal = `${formatCurrency.format(totalCart)} COP`;
    document.querySelector('#cart-total').textContent = formattedTotal; // Actualiza el total en el HTML
};



// Función para eliminar un producto del carrito
function removeFromCart(productId) {
    // Eliminar el producto del carrito
    cart = cart.filter(item => item.id !== productId);
    updateCartInSessionStorage(); // Actualiza el sessionStorage
    showCartHTML(); // Recargar los items del carrito
}

// Mostrar/Ocultar el panel de carrito
document.querySelector('#button-header-cart').addEventListener('click', () => {
    containerListCart.classList.toggle('show');
    containerListCart.style.display = containerListCart.classList.contains('show') ? 'block' : 'none';
});

document.querySelector('#btn-close-cart').addEventListener('click', () => {
    containerListCart.classList.remove('show');
    containerListCart.style.display = 'none'; // Ocultar el panel
});

// Cargar carrito al iniciar
loadCartFromSessionStorage();



//-----------------------------Pasarela de Pagos (Stripe)-------------------------------

// Inicializar Stripe con la clave pública
const stripe = Stripe('pk_test_51Q0vhZ051Vj2NhP2j7EARIyuHMWLChvZE5xI7CirJ7NJtdF1x3PEU9rUnC2ByYOS2ltFs8PCpy0UWKewzPpJWLf700yfT1yCWK');

// Seleccionar el botón de pago
const checkoutButton = document.querySelector('#checkout-button');

// Evento para cuando se haga clic en el botón de pago
checkoutButton.addEventListener('click', function() {
    const totalAmount = document.querySelector('#cart-total').textContent.replace(/[^\d.-]/g, '');

    // Verifica si el total es válido
    if (!totalAmount || isNaN(totalAmount)) {
        alert('Total del carrito no válido');
        return;
    }

    fetch('/Sicosis_Store/api/crear_sesion_pago.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            amount: totalAmount * 100, // Stripe trabaja en centavos
            currency: 'COP',
        }),
    })
    .then(response => response.json())
    .then(session => {
        if (session.id) {
            // Redirigir al checkout de Stripe
            return stripe.redirectToCheckout({ sessionId: session.id });
        } else {
            alert('Hubo un problema al crear la sesión de pago');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error al procesar el pago. Por favor, intenta de nuevo.');
    });
});




