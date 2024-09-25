// Manejo del registro de usuario, 
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

// Manejo de favoritos
const btnsFavorite = document.querySelectorAll('.heart-icon');
const containerListFavorites = document.querySelector('.container-list-favorites');
const listFavorites = document.querySelector('.list-favorites');
const counterFavorites = document.querySelector('.counter-favorite');

let favorites = [];

// Función para actualizar los favoritos en localStorage
const updateFavoritesInLocalStorage = () => {
    localStorage.setItem('favorites', JSON.stringify(favorites));
};

// Función para cargar los favoritos desde localStorage
const loadFavoritesFromLocalStorage = () => {
    const storedFavorites = localStorage.getItem('favorites');
    if (storedFavorites) {
        favorites = JSON.parse(storedFavorites);
        showHTML();
    }
};

// Función para manejar los clics en los iconos de corazón
function toggleHeart(event, productId) {
    event.preventDefault();

    const heartIcon = document.getElementById(`heart-icon-${productId}`);
    const heartFillIcon = document.getElementById(`heart-fill-icon-${productId}`);

    if (heartFillIcon.style.display === "none") {
        heartIcon.style.display = "none"; // Ocultar corazón vacío
        heartFillIcon.style.display = "inline"; // Mostrar corazón lleno

        const title = heartIcon.closest('.collapse').querySelector('.card-title').textContent; // Captura el título
        const price = heartIcon.closest('.collapse').querySelector('.list-group-item').textContent; // Captura el precio
        const imageUrl = heartIcon.closest('.card-small').querySelector('img').src; // Captura la URL de la imagen

        // Verifica si el producto no está ya en favoritos
        if (!favorites.some(fav => fav.id === productId)) {
            favorites.push({
                id: productId,
                title: title,
                price: price,
                image: imageUrl  // Agrega la URL de la imagen
            });
            updateFavoritesInLocalStorage();
        }
    } else {
        heartIcon.style.display = "inline"; // Mostrar corazón vacío
        heartFillIcon.style.display = "none"; // Ocultar corazón lleno

        // Eliminar de favoritos
        favorites = favorites.filter(fav => fav.id !== productId);
        updateFavoritesInLocalStorage();
    }

    showHTML();
}


// Función para mostrar el estado de favoritos en productos
const showHTML = () => {
    btnsFavorite.forEach(button => {
        const card = button.closest('.collapse');
        const productId = button.id.split('-')[1]; // Extrae el ID del botón

        const isFavorite = favorites.some(favorite => favorite.id === productId); // Verifica si es favorito
        button.classList.toggle('favorite-active', isFavorite); // Actualiza la clase del botón
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
            updateFavoritesInLocalStorage();  // Actualiza localStorage

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
        const cartButton = document.createElement('button');
        cartButton.classList.add('add-cart-btn');

        const cartIcon = document.createElement('i');
        cartIcon.classList.add('fas', 'fa-shopping-cart');  // Ícono de Font Awesome para carrito
        cartButton.appendChild(cartIcon);

        // Evento para agregar el producto al carrito (aquí puedes agregar la lógica que desees)
        cartButton.addEventListener('click', () => {
            alert(`Agregaste ${fav.title} al carrito`);  // Acción cuando se agrega al carrito (puedes cambiarla)
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
loadFavoritesFromLocalStorage();

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
                alert("Has iniciado sesión correctamente");
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
loadFavoritesFromLocalStorage();
