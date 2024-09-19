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

    const userData = {
        userName: userName,
        userApellido: userApellido,
        userEmail: userEmail,
        userPassword: userPassword
    };

    fetch('http://localhost/Sicosis_Store/model/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registro exitoso. Redirigiendo...');
            window.location.href = '/Sicosis_Store/homepage';  // Redirigir al homepage después del registro
        } else {
            alert("Error en el registro: " + data.message);
        }
    })
    .catch(error => {
        console.error("Hubo un problema con la solicitud de registro", error);
    });
}


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
    .then(response => response.text())  // Cambia aquí para inspeccionar la respuesta como texto
    .then(data => {
        console.log(data);  // Muestra el texto devuelto por el servidor
        try {
            const jsonData = JSON.parse(data);  // Intenta parsear como JSON
            if (jsonData.success) {
                alert("Has iniciado sesión correctamente");
                window.location.href = "/Sicosis_Store/homepage"; // Redirigir si es exitoso
            } else {
                alert("Error en el inicio de sesión: " + jsonData.message);
            }
        } catch (error) {
            console.error("Error al parsear JSON:", error);
            console.log("Respuesta no válida del servidor:", data);
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});




