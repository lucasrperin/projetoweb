<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projetoweb1";

// Criação da conexão
$conexao = new mysqli($servername, $username, $password, $dbname);

// Verificação da conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}
?>