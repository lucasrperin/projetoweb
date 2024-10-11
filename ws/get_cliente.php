<?php
// Configurar o cabeçalho para retornar JSON
header('Content-Type: application/json');

// Incluir o arquivo de conexão
include "../conecta.php"; // Usando __DIR__ para garantir o caminho correto

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

// Verificar o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        // Registrar log para acesso a cliente específico
        registrarLogAcesso("Acesso ao cliente ID: " . $_GET['id']);
        getCliente($_GET['id']);
    } else {
        // Registrar log para acesso à listagem de clientes
        registrarLogAcesso("Acesso à listagem de todos os clientes");
        getClientes();
    }
} else {
    // Método não permitido
    http_response_code(405); // Código HTTP para método não permitido
    echo json_encode(array('message' => 'Método não permitido. Apenas GET é aceito.'));
    registrarLogAcesso("Tentativa de acesso com método não permitido.");
    exit();
}

// Função para listar todos os clientes
function getClientes() {
    global $conexao;
    $SQL = "SELECT * FROM clientes ORDER BY cd_cliente";
    $result = mysqli_query($conexao, $SQL);

    if (!$result) {
        // Registrar erro na execução da consulta
        registrarLogAcesso("Erro ao listar clientes: " . mysqli_error($conexao));
        die(json_encode(array('message' => 'Erro ao listar clientes.')));
    }

    $clientes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $clientes[] = $row;
    }

    // Retornar os clientes em formato JSON
    echo json_encode($clientes);
}

// Função para listar um cliente específico pelo ID
function getCliente($id) {
    global $conexao;
    $SQL = "SELECT * FROM clientes WHERE cd_cliente = ?";
    
    // Usar prepared statements para evitar SQL Injection
    $stmt = $conexao->prepare($SQL);
    $stmt->bind_param("i", $id); // "i" indica que o parâmetro é um inteiro
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        // Registrar log se o cliente não for encontrado
        registrarLogAcesso("Cliente ID: $id não encontrado.");
        echo json_encode(array('message' => 'Cliente não encontrado.'));
    }

    $stmt->close(); // Fechar o statement
}
?>
