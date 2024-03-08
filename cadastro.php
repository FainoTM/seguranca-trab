<?php
global $conn;
require_once "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Hash da senha para segurança

    // Verifica se o e-mail já está cadastrado
    $sqlVerificaEmail = "SELECT id FROM usuarios WHERE email = ?";
    $stmtVerificaEmail = $conn->prepare($sqlVerificaEmail);
    $stmtVerificaEmail->bind_param("s", $email);
    $stmtVerificaEmail->execute();
    $resultVerificaEmail = $stmtVerificaEmail->get_result();

    if ($resultVerificaEmail->num_rows > 0) {
        $error = "E-mail já cadastrado. Tente outro.";
    } else {
        // Insere o novo usuário no banco de dados
        $sqlInsereUsuario = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmtInsereUsuario = $conn->prepare($sqlInsereUsuario);
        $stmtInsereUsuario->bind_param("sss", $nome, $email, $senha);

        if ($stmtInsereUsuario->execute()) {
            // Redireciona para a página de login após o cadastro bem-sucedido
            header("Location: login.php");
            exit();
        } else {
            $error = "Erro ao cadastrar usuário. Por favor, tente novamente.";
        }
    }

    $stmtVerificaEmail->close();
    $stmtInsereUsuario->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- Links para Bootstrap e CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 50px;
        }

        h2 {
            color: #007bff;
        }

        form {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #000000;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        p {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-3">Cadastro de Usuário</h2>
    <form method="post" action="cadastro.php" class="mt-3">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <input type="submit" value="Cadastrar" class="btn btn-success btn-block">
    </form>
    <p class="text-center mt-3">Já tem uma conta? <a href="login.php">Faça login</a></p>
</div>
</body>
</html>


