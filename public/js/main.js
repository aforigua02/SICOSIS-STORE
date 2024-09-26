// ------------------- Manejo de Registro de Usuario ------------------- //
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

// ------------------- Manejo de Favoritos ------------------- //
let favorites = [];

// Función para verificar si el usuario está logueado
const isLoggedIn = () => {
    return sessionStorage.getItem('user_id') !== null;
};

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

    if (!isLoggedIn()) {
        alert("Debes iniciar sesión para agregar productos a favoritos.");
        const loginModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
        loginModal.show();
        return;
    }

    const heartIcon = document.getElementById(`heart-icon-${productId}`);
    const heartFillIcon = document.getElementById(`heart-fill-icon-${productId}`);

    if (heartFillIcon.style.display === "none") {
        heartIcon.style.display = "none"; // Ocultar corazón vacío
        heartFillIcon.style.display = "inline"; // Mostrar corazón lleno

        const title = heartIcon.closest('.collapse').querySelector('.card-title').textContent;
        const price = heartIcon.closest('.collapse').querySelector('.list-group-item').textContent;
        const imageUrl = heartIcon.closest('.card-small').querySelector('img').src;

        // Verifica si el producto no está ya en favoritos
        if (!favorites.some(fav => fav.id === productId)) {
            favorites.push({ id: productId, title: title, price: price, image: imageUrl });
            updateFavoritesInLocalStorage();
        }
    } else {
        heartIcon.style.display = "inline";
        heartFillIcon.style.display = "none";

        // Eliminar de favoritos
        favorites = favorites.filter(fav => fav.id !== productId);
        updateFavoritesInLocalStorage();
    }

    showHTML();
}

// Función para mostrar el estado de favoritos en productos
const showHTML = () => {
    const btnsFavorite = document.querySelectorAll('.heart-icon');
    btnsFavorite.forEach(button => {
        const card = button.closest('.collapse');
        const productId = button.id.split('-')[1];
        const isFavorite = favorites.some(favorite => favorite.id === productId);
        button.classList.toggle('favorite-active', isFavorite);
    });

    updateFavoriteMenu(); // Actualiza el menú de favoritos
};

// Función para actualizar el menú de favoritos
const updateFavoriteMenu = () => {
    const listFavorites = document.querySelector('.list-favorites');
    const counterFavorites = document.querySelector('.counter-favorite');

    listFavorites.innerHTML = '';  // Limpiar la lista antes de actualizar

    favorites.forEach(fav => {
        const favoriteCard = document.createElement('div');
        favoriteCard.classList.add('card-favorite');

        const imageElement = document.createElement('img');
        imageElement.src = fav.image;
        imageElement.classList.add('favorite-image');
        favoriteCard.appendChild(imageElement);

        const infoContainer = document.createElement('div');
        infoContainer.classList.add('info-container');

        const titleElement = document.createElement('p');
        titleElement.classList.add('title');
        titleElement.textContent = fav.title;
        infoContainer.appendChild(titleElement);

        const priceElement = document.createElement('p');
        priceElement.classList.add('price');
        priceElement.textContent = fav.price;
        infoContainer.appendChild(priceElement);

        favoriteCard.appendChild(infoContainer);

        const iconContainer = document.createElement('div');
        iconContainer.classList.add('icon-container');

        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-favorite-btn');

        const trashIcon = document.createElement('i');
        trashIcon.classList.add('fas', 'fa-trash');
        deleteButton.appendChild(trashIcon);

        deleteButton.addEventListener('click', () => {
            favorites = favorites.filter(f => f.id !== fav.id);
            updateFavoritesInLocalStorage();

            const heartIcon = document.getElementById(`heart-icon-${fav.id}`);
            const heartFillIcon = document.getElementById(`heart-fill-icon-${fav.id}`);
            if (heartIcon && heartFillIcon) {
                heartIcon.style.display = "inline";
                heartFillIcon.style.display = "none";
            }

            showHTML();
        });

        iconContainer.appendChild(deleteButton);

        const cartButton = document.createElement('button');
        cartButton.classList.add('add-cart-btn');

        const cartIcon = document.createElement('i');
        cartIcon.classList.add('fas', 'fa-shopping-cart');
        cartButton.appendChild(cartIcon);

        cartButton.addEventListener('click', () => {
            alert(`Agregaste ${fav.title} al carrito`);
        });

        iconContainer.appendChild(cartButton);
        favoriteCard.appendChild(iconContainer);
        listFavorites.appendChild(favoriteCard);
    });

    counterFavorites.textContent = favorites.length;
};

// Manejo de eventos para los botones de favoritos
document.querySelectorAll('.heart-icon').forEach(button => {
    button.addEventListener('click', e => {
        const card = e.target.closest('.collapse');
        if (card) {
            const productId = card.dataset.id;
            toggleHeart(e, productId);
        }
    });
});

// Mostrar/Ocultar el panel de favoritos
document.querySelector('#button-header-favorite').addEventListener('click', () => {
    const containerListFavorites = document.querySelector('.container-list-favorites');
    containerListFavorites.classList.toggle('show');
    containerListFavorites.style.display = containerListFavorites.classList.contains('show') ? 'block' : 'none';
});

document.querySelector('#btn-close').addEventListener('click', () => {
    const containerListFavorites = document.querySelector('.container-list-favorites');
    containerListFavorites.classList.remove('show');
    containerListFavorites.style.display = 'none';
});

// ------------------- Manejo de Inicio de Sesión ------------------- //
document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault();

    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginpassword").value;

    if (!email || !password) {
        alert("Por favor, completa ambos campos.");
        return;
    }

    const formData = new FormData();
    formData.append("loginEmail", email);
    formData.append("loginpassword", password);

    fetch("/Sicosis_Store/model/login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.success) {
                sessionStorage.setItem('user_id', jsonData.userId);
                alert("Has iniciado sesión correctamente");
                const loginModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle'));
                loginModal.hide();
                window.location.href = "/Sicosis_Store/homepage";
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
