<?php
global $conn;
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM usuarios WHERE nome = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password against the hashed password stored in the database
        if (password_verify($password, $row["senha"])) {
            $_SESSION['username'] = $row["nome"];
            $_SESSION['password'] = $row["senha"];
            $_SESSION['id'] = $row["id"];

            // Redirect to the account page or do other actions after successful login
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuário ou senha inválidos!";
        }
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background-color: #007bff;
            color: #ffffff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-3">Login</h2>
    <form method="post" action="" class="mt-3">
        <div class="form-group">
            <label for="username">Usuário:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <input type="submit" value="Login" class="btn btn-primary btn-block">
    </form>
    <p class="text-center mt-3">Não tem uma conta? <a href="cadastro.php">Crie Uma!</a></p>
    <?php if(isset($error)) { echo "<p class='text-danger text-center'>$error</p>"; } ?>
</div>
</body>
</html>
