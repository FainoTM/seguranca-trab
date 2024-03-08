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

$sql = "SELECT u.nome, c.saldo FROM usuarios u JOIN banco.contas c ON u.id = c.id_usuario WHERE u.id = '$id'";
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

// Check if the query returned any rows
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("No data found for the user with ID: $id");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Conta</title>
    <!-- Bootstrap CSS link -->
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
    </style>
</head>
<body>
<div class="container">
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

        <button type="submit" class="btn btn-primary">Transferir</button>
    </form>
</div>

<!-- Bootstrap JS and Popper.js scripts (needed for some Bootstrap components) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
