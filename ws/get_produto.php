<?php
header('Content-Type: application/json');
include "../conecta.php";

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Buscar um produto específico
        getProduto($_GET['id']);
    } else {
        // Listar todos os produtos
        getProdutos();
    }
} else {
    // Método não permitido
    http_response_code(405); // Método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
}

// Função para listar todos os produtos
function getProdutos() {
    global $conexao;
    $SQL = "SELECT * FROM produtos ORDER BY cd_produto";
    $result = mysqli_query($conexao, $SQL);
    
    $produtos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }
    
    echo json_encode($produtos);
}

// Função para listar um produto específico
function getProduto($id) {
    global $conexao;
    $SQL = "SELECT * FROM produtos WHERE cd_produto = $id";
    $result = mysqli_query($conexao, $SQL);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(array('message' => 'Cliente não encontrado.'));
    }
}
?>