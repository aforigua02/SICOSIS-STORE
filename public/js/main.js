document.getElementById('loginButton').addEventListener('click', function() {
    const email = document.getElementById('staticEmail').value;
    const password = document.getElementById('inputPassword').value;
    console.log(email, password);  // Para verificar que los valores se capturan correctamente
    // Llamamos a la API para verificar los datos del inicio de sesión
    loginUser(email, password);
});

document.getElementById('registerButton').addEventListener('click', function() {
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Llamamos a la API para registrar un nuevo usuario
    registerUser(nombre, email, password);
});

function loginUser(email, password) {
    fetch('/Sicosis_Store/api_rest/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Lógica cuando el inicio de sesión es exitoso, como redirigir a otra página
            alert('Inicio de sesión exitoso');
        } else {
            // Manejo de errores
            alert('Error en inicio de sesión: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


function registerUser(nombre, email, password) {
    fetch('/Sicosis_Store/api_rest/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nombre, email, password }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Lógica cuando el registro es exitoso
            alert('Usuario registrado exitosamente');
        } else {
            // Manejo de errores
            alert('Error en el registro: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}


