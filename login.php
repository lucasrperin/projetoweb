<?php
$ds_email = $_POST["ds_email"];
$ds_senha = $_POST["ds_senha"];

if ((strlen($ds_email) > 5) && (strlen($ds_senha) >= 3)) {
    include "conecta.php";
    $ds_email = mysqli_real_escape_string($conexao, $ds_email);
    $SQL = "SELECT * FROM usuarios WHERE ds_email = '$ds_email' ";
    $RSS = mysqli_query($conexao, $SQL) or die(mysqli_error($conexao));
    $RSX = mysqli_fetch_assoc($RSS); 	
    if ($RSX["ds_email"] == $ds_email) {
        $SQL = "SELECT * FROM usuarios WHERE ds_email = '$ds_email' AND ds_senha = '$ds_senha' ";
        $RSS = mysqli_query($conexao, $SQL) or die(mysqli_error($conexao));
        $RSX = mysqli_fetch_assoc($RSS); 	
        if ($RSX["ds_senha"] == $ds_senha) {      
            echo "Login aceito <br><br> Bem vindo";
            header("Location: menu.php?modulo=listagem_cliente");
            exit();
        } else {
            echo "<script>alert('Senha errada'); window.location.href = 'index.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Usuário Inexistente.'); window.location.href = 'index.html';</script>";
        exit();
    }
} else {
    echo "<script>alert('Email ou senha inválidos.'); window.location.href = 'index.html';</script>";
    exit();
}
?>
