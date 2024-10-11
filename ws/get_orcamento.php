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
        // Registrar log do acesso ao orçamento específico
        registrarLogAcesso("Acesso ao orçamento ID: " . $_GET['id']);
        getOrcamento($_GET['id']);
    } else {
        // Registrar log de listagem de todos os orçamentos
        registrarLogAcesso("Acesso à listagem de todos os orçamentos");
        getOrcamentos();
    }
} else {
    // Método não permitido
    http_response_code(405); // Código HTTP para método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
    registrarLogAcesso("Tentativa de acesso com método não permitido.");
    exit();
}

// Função para listar todos os orçamentos
function getOrcamentos() {
    global $conexao;
    $SQL = "SELECT * FROM orcamentos ORDER BY cd_orcamento";
    $result = mysqli_query($conexao, $SQL);
    
    if (!$result) {
        // Registrar erro na execução da consulta
        registrarLogAcesso("Erro ao listar orçamentos: " . mysqli_error($conexao));
        die(json_encode(array('message' => 'Erro ao listar orçamentos.')));
    }

    $orcamentos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $orcamentos[] = $row;
    }

    // Retornar os orçamentos em formato JSON
    echo json_encode($orcamentos);
}

// Função para listar um orçamento específico
function getOrcamento($id) {
    global $conexao;
    $SQL = "SELECT * FROM orcamentos WHERE cd_orcamento = ?";
    
    // Usar prepared statements para evitar SQL Injection
    $stmt = $conexao->prepare($SQL);
    $stmt->bind_param("i", $id); // "i" indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        // Registrar log se o orçamento não for encontrado
        registrarLogAcesso("Orçamento ID: $id não encontrado.");
        echo json_encode(array('message' => 'Orçamento não encontrado.'));
    }

    $stmt->close(); // Fechar o statement
}
?>
