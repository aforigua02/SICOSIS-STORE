<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Admin</title>
</head>
<body class="login-admin">
    <header class="contenedor-login">
        <div class="login">
            <h3 class="titulo-login">Iniciar Sesión</h3>
            <form id="formulario" class="contenedor-form" action="../model/modeladmin.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address <i class="bi bi-person-fill"></i></label>
                    <input type="email" class="form-control" id="staticEmail" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password <i class="bi bi-lock-fill"></i></label>
                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary button-submit">Login</button>
            </form>
        </div>
    </header>


    <script src="../public/js/main.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>