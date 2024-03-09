<?php
global $conn;
session_start();
include("db_connection.php");


function showPopup($message, $redirect) {
    echo "<script>
            var confirmPopup = confirm('$message');
            if (confirmPopup) {
                window.location.href = '$redirect';
            } else {
                alert('Obrigado por usar!');
                window.location.href = 'obrigado.php'; // Replace 'obrigado.php' with the actual thank you page
            }
          </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have sanitized the input data for security
    $destino = $_POST["destino"];
    $valor = $_POST["valor"];

    // Fetch current user information - Placeholder, modify based on your actual logic
    $user = $_SESSION["username"];
    $id = $_SESSION["id"];
    $sql_user = "SELECT u.nome, c.saldo FROM usuarios u JOIN banco.contas c ON u.id = c.id_usuario WHERE u.id = '$id'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $row = $result_user->fetch_assoc();
        $saldo_origem = $row["saldo"]; // Assuming $row includes the necessary information
    } else {
        die("Error: User information not found.");
    }

    // Fetch destination account information
    $sql_destino = "SELECT * FROM banco.contas WHERE numero_conta = '$destino'";
    $result_destino = $conn->query($sql_destino);

    if ($result_destino->num_rows > 0) {
        $row_destino = $result_destino->fetch_assoc();
        $id_usuario_destino = $row_destino["id_usuario"];
        $saldo_destino = $row_destino["saldo"];

        // Check if the source account has sufficient balance
        if ($saldo_origem >= $valor || $saldo_destino = 0) {
            // Perform the transfer
            $novo_saldo_origem = $saldo_origem - $valor;
            $novo_saldo_destino = $saldo_destino + $valor;

            // Update source account
            $sql_update_origem = "UPDATE banco.contas SET saldo = '$novo_saldo_origem' WHERE id_usuario = '$id'";
            $conn->query($sql_update_origem);

            // Update destination account
            $sql_update_destino = "UPDATE banco.contas SET saldo = '$novo_saldo_destino' WHERE id_usuario = '$id_usuario_destino'";
            $conn->query($sql_update_destino);

            // Log the transaction or perform any other necessary actions

            // Redirect to conta.php or another page
            showPopup("Transferência realizada com sucesso! Deseja realizar outra?", "conta.php");
            exit();
        } else {
            echo "Saldo insuficiente para realizar a transferência.";
        }
    } else {
        $error = "Conta de destino não encontrada.";
    }
}

$conn->close();

