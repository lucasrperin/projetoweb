<?php
header('Content-Type: application/json');
include "../conecta.php";

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Buscar um orçamento específico
        getOrcamento($_GET['id']);
    } else {
        // Listar todos os orçamentos
        getOrcamentos();
    }
} else {
    // Método não permitido
    http_response_code(405); // Método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
}

// Função para listar todos os orçamentos
function getOrcamentos() {
    global $conexao;
    $SQL = "SELECT * FROM orcamentos ORDER BY cd_orcamento";
    $result = mysqli_query($conexao, $SQL);
    
    $orcamentos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orcamentos[] = $row;
    }
    
    echo json_encode($orcamentos);
}

// Função para listar um orçamento específico
function getOrcamento($id) {
    global $conexao;
    $SQL = "SELECT * FROM orcamentos WHERE cd_orcamento = $id";
    $result = mysqli_query($conexao, $SQL);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(array('message' => 'Orçamento não encontrado.'));
    }
}
?>
