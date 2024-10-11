<?php
session_start();
include '../conecta.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['usuario'];
$sql = "SELECT cd_usuario FROM USUARIOS WHERE ds_email = ?";

if ($stmt = $conexao->prepare($sql)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($cd_usuario);
    $stmt->fetch();

    if ($cd_usuario) { // Verifica se o cd_usuario foi obtido
        $_SESSION['cd_usuario'] = $cd_usuario;
    } else {
        // Opcional: Se não encontrar o cd_usuario, redirecione de volta para o login
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
</head>
<body>
    <h2>Menu</h2>
    <ul>
        <li>
            <a href="cadastro_cliente.php?cd_usuario=<?php echo urlencode($_SESSION['cd_usuario']); ?>">Clientes</a>
        </li>
    </ul>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</p>
    <a href="login.php">Sair</a>
</body>
</html>
