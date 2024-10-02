<?php
header('Content-Type: application/json');
include "../conecta.php";

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Buscar um cliente específico
        getCliente($_GET['id']);
    } else {
        // Listar todos os clientes
        getClientes();
    }
} else {
    // Método não permitido
    http_response_code(405); // Método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
}

// Função para listar todos os clientes
function getClientes() {
    global $conexao;
    $SQL = "SELECT * FROM clientes ORDER BY cd_cliente";
    $result = mysqli_query($conexao, $SQL);
    
    $clientes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $clientes[] = $row;
    }
    
    echo json_encode($clientes);
}

// Função para listar um cliente específico
function getCliente($id) {
    global $conexao;
    $SQL = "SELECT * FROM clientes WHERE cd_cliente = $id";
    $result = mysqli_query($conexao, $SQL);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(array('message' => 'Cliente não encontrado.'));
    }
}
?>