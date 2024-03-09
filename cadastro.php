<?php
global $conn;
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have sanitized the input data for security
    $username = $_POST["nome"];
    $email = $_POST["email"];
    $password = password_hash($_POST["senha"], PASSWORD_DEFAULT); // Hash the password

    // Insert new user into 'usuarios' table
    $sql_insert_user = "INSERT INTO usuarios (nome, email, senha) VALUES ('$username', '$email', '$password')";
    $result_insert_user = $conn->query($sql_insert_user);

    if ($result_insert_user) {
        // Get the ID of the newly inserted user
        $new_user_id = $conn->insert_id;

        // Generate a random account number
        $numero_conta = generateAccountNumber();

        // Insert a corresponding account into 'contas' table with an initial balance of 0.00
        $sql_insert_account = "INSERT INTO contas (id_usuario, numero_conta, tipo_conta, agencia, saldo, historico_transacoes)
                               VALUES ('$new_user_id', '$numero_conta', 'Conta Padrão', '001', 0.00, 'Nova conta criada')";
        $result_insert_account = $conn->query($sql_insert_account);

        if ($result_insert_account) {
            // Redirect to a success page or perform other actions
            header("Location: login.php");
            exit();
        } else {
            $error = "Erro ao criar conta. Por favor, tente novamente.";
        }
    } else {
        $error = "Erro ao cadastrar usuário. Por favor, tente novamente.";
    }
}

// Function to generate a random account number
function generateAccountNumber() {
    $digits = 7; // Adjust the number of digits for your account number
    return mt_rand(pow(10, $digits-1), pow(10, $digits)-1);
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


