<?php
global $conn;
session_start();
include("db_connection.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION["username"];
$id = $_SESSION["id"];
$sql = "SELECT * FROM usuarios u JOIN banco.contas c ON u.id = c.id_usuario WHERE u.id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["voltar"])) {
    // Redirect to the index page
    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add links for Bootstrap and CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }

        h2 {
            color: #007bff; /* Bootstrap primary color */
        }

        p {
            margin-bottom: 10px;
        }

        form {
            margin-top: 20px;
        }

        .voltar-btn {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Voltar button -->
    <form method="post" class="voltar-btn">
        <button type="submit" class="btn btn-info">Voltar</button>
        <input type="hidden" name="voltar" value="1">
    </form>

    <!-- Logout button -->
    <form method="post" class="logout-btn">
        <button type="submit" class="btn btn-danger">Logout</button>
        <input type="hidden" name="logout" value="1">
    </form>

    <h2 class="mt-4">Dados Bancários</h2>
    <p>Usuário: <?php echo $row["nome"]; ?></p>
    <p>Saldo: R$ <?php echo $row["saldo"]; ?></p>

    <h2 class="mt-4">Realizar Transferência</h2>
    <form method="post" action="transferencia.php">
        <div class="form-group">
            <label for="destino">Conta do Destino:</label>
            <input type="text" class="form-control" name="destino" required>
        </div>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="number" class="form-control" name="valor" required>
        </div>

        <input type="submit" class="btn btn-primary" value="Transferir">
    </form>
</div>

<!-- Bootstrap JS and Popper.js scripts (needed for some Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
