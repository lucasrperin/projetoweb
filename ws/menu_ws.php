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

    if ($cd_usuario) {
        $_SESSION['cd_usuario'] = $cd_usuario;
    } else {
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
    <link rel="stylesheet" href="../ws/css/menu_ws.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Menu</h1>
        </div>
        <a href="login.php" class="logout-button">
            <span>Sair</span> <i class="fas fa-sign-out-alt"></i>
        </a>
    </header>

    <main class="container1">
        <section>
            <h2>Opções</h2>
            <ul>
                <li>
                    <a href="#" id="linkCliente" onclick="navigateTo('cliente')">Clientes</a>
                    <input type="number" id="idCliente" placeholder="ID" class="hidden" disabled>
                </li>
                <li>
                    <a href="#" id="linkOrcamento" onclick="navigateTo('orcamento')">Orçamentos</a>
                    <input type="number" id="idOrcamento" placeholder="ID" class="hidden" disabled>
                </li>
                <li>
                    <a href="#" id="linkProduto" onclick="navigateTo('produto')">Produtos</a>
                    <input type="number" id="idProduto" placeholder="ID" class="hidden" disabled>
                </li>
                <li>
                    <a href="insert_cliente.php" >WS Eduardo</a>
                </li>
                <li>
                    <a href="insert_cliente1.php" >WS Cauã</a>
                </li>
                <li class="checkbox-item">
                    <label for="informarIdCheckbox">
                        <input type="checkbox" id="informarIdCheckbox"> Informar ID
                    </label>
                </li>
            </ul>

            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</p>
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
        <p>&copy; 2024 WEB Service. Todos os direitos reservados.</p>
    </footer>

    <script>
        const checkbox = document.getElementById('informarIdCheckbox');
        const inputs = document.querySelectorAll('ul li input[type="number"]');

        checkbox.addEventListener('change', function () {
            inputs.forEach(input => {
                input.classList.toggle('hidden', !checkbox.checked);
                input.disabled = !checkbox.checked;
            });
        });

        function navigateTo(type) {
            const baseUrl = "http://192.168.0.114/projetoweb/ws/get_";
            const idField = document.getElementById(`id${capitalizeFirstLetter(type)}`);
            let url = `${baseUrl}${type}.php`;

            if (!idField.classList.contains('hidden') && idField.value) {
                url += `?id=${idField.value}`;
            }

            window.open(url, "_blank");
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        

        
    </script>
</body>
</html>
