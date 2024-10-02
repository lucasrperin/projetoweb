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

// Consulta para obter todos os clientes
$clientes = [];
$SQL = "SELECT * FROM clientes";
$stmt = mysqli_prepare($conexao, $SQL);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($resultado)) {
    $clientes[] = $row;
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Clientes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Cidade</th>
                    <th>UF</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $c): ?>
                    <tr>
                        <td><?php echo $c['cd_cliente']; ?></td>
                        <td><?php echo $c['ds_cliente']; ?></td>
                        <td><?php echo $c['ds_email']; ?></td>
                        <td><?php echo $c['ds_celular']; ?></td>
                        <td><?php echo $c['ds_cidade_cliente']; ?></td>
                        <td><?php echo $c['ds_uf_cliente']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button class="btn btn-success" onclick="window.location.href='cadastrar_cliente.php?cd_usuario=<?php echo $cd_usuario; ?>'">Novo</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
