<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registrousuariosnuevos";

// Crear la conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

$registro_exitoso = false;
$error_msg = "";

// Verificar si los datos del formulario están presentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validaciones del lado del servidor
    if (empty($email)) {
        $error_msg = "El campo de correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "El correo electrónico no es válido.";
    } elseif (empty($password)) {
        $error_msg = "El campo de contraseña es obligatorio.";
    } else {
        // Preparar la consulta SQL usando sentencias preparadas
        $stmt = $conexion->prepare("INSERT INTO registro (email, password) VALUES (?, ?)");
        if ($stmt === false) {
            $error_msg = "Error en la preparación de la consulta: " . $conexion->error;
        } else {
            // Bind de los parámetros
            $stmt->bind_param("ss", $email, $password);

            // Ejecutar la consulta y verificar errores
            if ($stmt->execute()) {
                $registro_exitoso = true;
            } else {
                $error_msg = "Error: " . $stmt->error;
            }

            // Cerrar la conexión
            $stmt->close();
        }
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var errorMsg = "";

            if (email === "") {
                errorMsg += "El campo de correo electrónico es obligatorio.\n";
            } else if (!/\S+@\S+\.\S+/.test(email)) {
                errorMsg += "El correo electrónico no es válido.\n";
            }

            if (password === "") {
                errorMsg += "El campo de contraseña es obligatorio.\n";
            }

            if (errorMsg !== "") {
                alert(errorMsg);
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Navbar content -->
            <a class="navbar-brand" href="#">Tokitodog</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="TokitoColombia_1.html">Home</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Mensaje de registro -->
    <div class="container mt-3">
        <?php if ($registro_exitoso): ?>
            <div class="alert alert-success" role="alert">
                Nuevo registro creado exitosamente.
            </div>
        <?php elseif (!empty($error_msg)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Registro y Login -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Registrate</h2>
                <form action="registro.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white bg-dark p-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-5 col-6">
                    <address>
                        <strong>Tokitodog Colombia.</strong><br>
                        Cali, Valle del Cauca<br>
                        Whatsapp +57 323 4728918<br>
                    </address>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>Copyright © Tokitodog. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
</body>
</html>
