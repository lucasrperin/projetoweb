<?php
session_start();
include '../conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username']; // Campo de email
    $password = $_POST['password']; // Campo de senha

    // Consulta SQL usando prepared statement para buscar o usuário pelo email
    $sql = "SELECT CD_USUARIO, DS_SENHA FROM USUARIOS WHERE ds_email = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Vincula o parâmetro email
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se o email foi encontrado
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Verifique se a senha fornecida corresponde à senha hash no banco de dados
            if (password_verify($password, $row['DS_SENHA'])) {
                // Armazena o ID do usuário na sessão
                $_SESSION['ID_USUARIO'] = $row['CD_USUARIO'];
                header("Location: menu_ws.php");
                exit();
            } else {
                // Senha incorreta
                $_SESSION['error_message'] = "<p class='error'>Senha incorreta</p>";
            }
        } else {
            // Usuário não encontrado
            $_SESSION['error_message'] = "<p class='error'>Usuário não encontrado</p>";
        }

        // Fecha o statement
        $stmt->close();
    }
    // Redireciona de volta para a página de login
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../ws/css/login.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Login</h1>
        </div>
    </header>
    <main class="container">
        <section id="login">
            <h2>Entrar</h2>
            <form action="login.php" method="post">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Entrar</button>
            </form>
            <p>Não tem uma conta? <a href="register.php">Cadastre-se aqui</a></p>
            <div class="error-message">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>
            </div>
        </section>
    </main>
    <footer id="site-footer">
        <a href="https://wa.me/+55numero" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </a>
        <a href="https://www.facebook.com" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook">
        </a>
        <a href="https://www.instagram.com" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
        </a>
        <p>&copy; 2024 Site de Eventos. Todos os direitos reservados.</p>
    </footer>
</body>
</html>