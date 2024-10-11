<?php
session_start(); // Inicia a sessão

// Destrói todas as variáveis de sessão
$_SESSION = array(); 

// Se você também quiser destruir a sessão em si
session_destroy();

// Redireciona para a página de login
header("Location: login.php");
exit();
?>
