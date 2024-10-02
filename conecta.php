<?php
$servername = "localhost"; // ou o nome do servidor do seu banco de dados
$username = "root";        // seu nome de usuário
$password = "";            // sua senha
$dbname = "projetoweb1";    // o nome do seu banco de dados

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação da conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>