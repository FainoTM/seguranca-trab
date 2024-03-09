<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Banco XYZ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Bootstrap background color */
        }

        .navbar {
            background-color: #007bff; /* Bootstrap primary color */
        }

        .navbar-brand,
        .navbar-nav a {
            color: #ffffff !important; /* White text color */
        }

        .container {
            margin-top: 20px;
            text-align: center;
        }

        h1 {
            color: #007bff; /* Bootstrap primary color */
        }

        .info-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">
        Banco XYZ
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
                // Destroy the session and redirect to the login page
                session_destroy();
                header("Location: login.php");
                exit();
            }

            // Check if the user is logged in
            session_start();
            if (isset($_SESSION["username"])) {
                echo '<li class="nav-item">
                            <a class="nav-link" href="conta.php">Acessar Conta</a>
                          </li> <li><form method="post" class="logout-btn">
                            <button type="submit" class="btn btn-danger">Logout</button>
        <input type="hidden" name="logout" value="1">
    </form></li>';

            } else {
                echo '<li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                          </li>';
            }
            ?>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1>Bem-vindo ao Banco XYZ</h1>

    <div class="row">
        <!-- Information Cards -->
        <div class="col-md-4">
            <div class="info-card">
                <h4>Sobre Nós</h4>
                <p>Descubra mais sobre o Banco XYZ e nossa história.</p>
                <a href="#" class="btn btn-primary">Saiba Mais</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <h4>Nossos Serviços</h4>
                <p>Explore os diversos serviços oferecidos pelo Banco XYZ.</p>
                <a href="#" class="btn btn-primary">Veja Serviços</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <h4>Contate-nos</h4>
                <p>Entre em contato conosco para obter suporte ou informações adicionais.</p>
                <a href="#" class="btn btn-primary">Entre em Contato</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js scripts (needed for some Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
