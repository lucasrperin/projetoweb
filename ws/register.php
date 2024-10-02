<?php
session_start();
include '../conecta.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash da senha

    // Verificar se o usuário ou email já existem
    $sql = "SELECT * FROM USUARIOS WHERE ds_usuario = ? OR ds_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Usuário ou email já existem.";
    } else {
        // Definir o cargo como 'Usuario'
        $cargo = 'Usuario';

        // Inserir o novo usuário
        $sql = "INSERT INTO USUARIOS (ds_usuario, ds_email, ds_senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute() === TRUE) {
            $_SESSION['success_message'] = "Usuário cadastrado com sucesso";
            header("Location: menu_ws.php"); // Redirecionar para a página home
            exit();
        } else {
            $_SESSION['error_message'] = "Erro: " . $stmt->error;
        }
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../ws/css/login.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Cadastro</h1>
        </div>
    </header>
    <main class="container">
    <section id="register">
        <h2>Cadastre-se</h2>
        <form action="register.php" method="post">
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Cadastrar</button>
            <p>Já tem uma conta? <a href="login.php">Entre aqui</a></p>
        </form>
        
        <div class="message">
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<p class='error'>{$_SESSION['error_message']}</p>";
            unset($_SESSION['error_message']);
        } elseif (isset($_SESSION['success_message'])) {
            echo "<p class='success'>{$_SESSION['success_message']}</p>";
            unset($_SESSION['success_message']);
        }
        ?>
        </div>
    </section>
</main>
    <footer id="site-footer">
        <a href="https://wa.me/+5549984198200" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </a>
        <a href="https://www.facebook.com/profile.php?id=61559906834926&locale=pt_BR" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook">
        </a>
        <a href="https://www.instagram.com/nivel3c4/" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
        </a>
        <p>&copy; 2024 Site de Eventos. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
