<?php
header('Content-Type: application/json');
include "../conecta.php"; // Certifique-se de que o caminho para o conecta.php está correto

// Função para registrar o IP e mensagens de log em um arquivo
function registrarLogAcesso($mensagem) {
    $arquivo = __DIR__ . '/acesso_log.txt'; // Caminho absoluto para o arquivo de log
    $dataHora = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR']; // Obtém o IP do cliente
    $log = "[$dataHora] - IP: $ip - $mensagem\n";
    
    // Escreve a mensagem no arquivo de log
    file_put_contents($arquivo, $log, FILE_APPEND);
}

// Testar a conexão com o banco de dados
if (!$conexao || $conexao->connect_error) {
    // Log do erro de conexão
    registrarLogAcesso("Erro de conexão com o banco de dados: " . $conexao->connect_error);
    // Retornar erro de conexão
    die(json_encode(array('message' => 'Erro na conexão com o banco de dados.')));
}

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Registrar log do acesso ao produto específico
        registrarLogAcesso("Acesso ao produto ID: " . $_GET['id']);
        getProduto($_GET['id']);
    } else {
        // Registrar log de listagem de todos os produtos
        registrarLogAcesso("Acesso à listagem de todos os produtos");
        getProdutos();
    }
} else {
    // Método não permitido
    http_response_code(405); // Método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
    registrarLogAcesso("Tentativa de acesso com método não permitido.");
    exit();
}

// Função para listar todos os produtos
function getProdutos() {
    global $conexao;
    $SQL = "SELECT * FROM produtos ORDER BY cd_produto";
    $result = mysqli_query($conexao, $SQL);
    
    if (!$result) {
        // Registrar erro na execução da consulta
        registrarLogAcesso("Erro ao listar produtos: " . mysqli_error($conexao));
        die(json_encode(array('message' => 'Erro ao listar produtos.')));
    }

    $produtos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $produtos[] = $row;
    }

    // Retornar os produtos em formato JSON
    echo json_encode($produtos);
}

// Função para listar um produto específico
function getProduto($id) {
    global $conexao;
    $SQL = "SELECT * FROM produtos WHERE cd_produto = ?";
    
    // Usar prepared statements para evitar SQL Injection
    $stmt = $conexao->prepare($SQL);
    $stmt->bind_param("i", $id); // "i" indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        // Registrar log se o produto não for encontrado
        registrarLogAcesso("Produto ID: $id não encontrado.");
        echo json_encode(array('message' => 'Produto não encontrado.'));
    }

    $stmt->close(); // Fechar o statement
}
?>
