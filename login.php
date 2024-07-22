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

$login_exitoso = false;
$error_msg = "";

// Verificar si los datos del formulario están presentes
if (isset($_POST['login-email']) && isset($_POST['login-password'])) {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    // Preparar la consulta SQL usando sentencias preparadas
    $stmt = $conexion->prepare("SELECT * FROM registro WHERE email = ? AND password = ?");
    if ($stmt === false) {
        $error_msg = "Error en la preparación de la consulta: " . $conexion->error;
    } else {
        // Bind de los parámetros
        $stmt->bind_param("ss", $email, $password);

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró una coincidencia
        if ($result->num_rows > 0) {
            $login_exitoso = true;
        } else {
            $error_msg = "Error en email o password, intenta de nuevo.";
        }
        
        // Cerrar la conexión
        $stmt->close();
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

    <!-- Mensaje de login -->
    <div class="container mt-3">
        <?php if ($login_exitoso): ?>
            <div class="alert alert-success" role="alert">
                Login exitoso. Bienvenido.
            </div>
        <?php elseif (!empty($error_msg)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Registro y Login -->
            <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <h2 class="text-center">Login</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="login-email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="login-email" name="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Contraseña</label>
                        <input type="password" class="form-control" id="login-password" name="login-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
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
