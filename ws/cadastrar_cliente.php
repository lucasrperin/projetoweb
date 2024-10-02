<?php
session_start(); // Inicia a sessão

// Verifica se o cd_usuario foi passado
if (isset($_GET['cd_usuario'])) {
    $cd_usuario = $_GET['cd_usuario'];
} elseif (isset($_SESSION['cd_usuario'])) {
    $cd_usuario = $_SESSION['cd_usuario'];
} else {
    header("Location: menu_ws.php"); // Redireciona se não houver cd_usuario
    exit();
}

include "../conecta.php"; // Conexão com o banco de dados

// Verifica a permissão do usuário
$SQL = "SELECT permissao FROM usuarios WHERE cd_usuario = ?";
$stmt = mysqli_prepare($conexao, $SQL);
mysqli_stmt_bind_param($stmt, "i", $cd_usuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $permissao);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!isset($permissao) || $permissao != 1) {
    echo "<h2>Acesso negado. Você não tem permissão.</h2>";
    exit();
}

// Verifica se os dados do cliente foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ds_cliente = $_POST['ds_cliente'];
    $ds_email = $_POST['ds_email'];
    $ds_celular = $_POST['ds_celular'];
    $ds_cidade_cliente = $_POST['ds_cidade_cliente'];
    $ds_uf_cliente = $_POST['ds_uf_cliente'];

    $SQL = "INSERT INTO clientes (ds_cliente, ds_email, ds_celular, ds_cidade_cliente, ds_uf_cliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $SQL);
    mysqli_stmt_bind_param($stmt, "sssss", $ds_cliente, $ds_email, $ds_celular, $ds_cidade_cliente, $ds_uf_cliente);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: menu.php?modulo=listagem_cliente"); // Redireciona após salvar
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Cliente</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Cliente</h1>
        <form method="POST" id="clienteForm">
            <div class="form-group">
                <label for="ds_cliente">Nome:</label>
                <input type="text" class="form-control" id="ds_cliente" name="ds_cliente" required>
            </div>
            <div class="form-group">
                <label for="ds_email">Email:</label>
                <input type="email" class="form-control" id="ds_email" name="ds_email" required>
            </div>
            <div class="form-group">
                <label for="ds_celular">Celular:</label>
                <input type="text" class="form-control" id="ds_celular" name="ds_celular" required>
            </div>
            <div class="form-group">
                <label for="ds_cidade_cliente">Cidade:</label>
                <input type="text" class="form-control" id="ds_cidade_cliente" name="ds_cidade_cliente" required>
            </div>
            <div class="form-group">
                <label for="ds_uf_cliente">UF:</label>
                <input type="text" class="form-control" id="ds_uf_cliente" name="ds_uf_cliente" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
