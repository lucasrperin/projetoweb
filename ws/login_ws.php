<?php
session_start();
include '../conecta.php'; // Inclui o arquivo de conexão

// Inicializa variáveis
$email = "";
$senha = "";
$message = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara e executa a consulta
    $sql = "SELECT ds_senha FROM usuarios WHERE ds_email = ?";
    $stmt = mysqli_prepare($conexao, $sql); // Usa $conexao aqui

    if ($stmt) { // Verifica se a preparação da consulta foi bem-sucedida
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $senha_armazenada);
            mysqli_stmt_fetch($stmt);

            // Verifica a senha em texto simples
            if ($senha === $senha_armazenada) {
                // Login bem-sucedido
                $_SESSION['usuario'] = $email; // Armazena o email na sessão
                header("Location: menu_ws.php"); // Redireciona para menu_ws.php
                exit();
            } else {
                // Senha incorreta
                $message = "Usuário ou senha incorretos.";
            }
        } else {
            // Usuário não encontrado
            $message = "Usuário ou senha incorretos.";
        }

        // Fecha a declaração
        mysqli_stmt_close($stmt);
    } else {
        $message = "Erro ao preparar a consulta.";
    }

    // Fecha a conexão
    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>
        
        <input type="submit" value="Entrar">
        <a href="login_ws.php">Cadastre-se</a>
        <input type="submit">
    </form>
</body>
</html>
