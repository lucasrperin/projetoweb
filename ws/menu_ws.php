<?php
session_start();
include '../conecta.php'; // Inclua a conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtém o cd_usuario do banco de dados a partir do email armazenado na sessão
$email = $_SESSION['usuario'];
$sql = "SELECT cd_usuario FROM usuarios WHERE ds_email = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $email); // Vincula o email como parâmetro
    $stmt->execute();               // Executa a consulta
    $stmt->bind_result($cd_usuario); // Associa a variável ao resultado
    $stmt->fetch();                 // Obtém o resultado

    // Armazena cd_usuario na sessão
    $_SESSION['cd_usuario'] = $cd_usuario;

    $stmt->close(); // Fecha o statement
}

$conn->close(); // Fecha a conexão com o banco de dados
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
        <!-- Adicione mais itens de menu conforme necessário -->
    </ul>
    <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</p>
    <a href="login.php">Sair</a> <!-- Link para logout -->
    
</body>
</html>
