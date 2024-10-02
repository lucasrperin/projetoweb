<?php
header("Content-Type: application/json");
include "../conecta.php"; // Conexão com o banco de dados

$method = $_SERVER['REQUEST_METHOD'];
$cd_cliente = isset($_REQUEST['cd_cliente']) ? intval($_REQUEST['cd_cliente']) : null;

// Suponha que você está recebendo um ID de usuário
$cd_usuario = isset($_REQUEST['cd_usuario']) ? intval($_REQUEST['cd_usuario']) : null;


switch ($method) {
    case 'GET':
        if ($cd_usuario) {
            $SQL = "SELECT permissao FROM usuarios WHERE cd_usuario = $cd_usuario";
            $RSS = mysqli_query($conexao, $SQL);
            $user = mysqli_fetch_assoc($RSS);

            if ($user && $user['permissao'] == 1) {
                if ($cd_cliente) {
                    // Retorna um cliente específico
                    $SQL = "SELECT * FROM clientes WHERE cd_cliente = $cd_cliente";
                    $RSS = mysqli_query($conexao, $SQL);
                    $client = mysqli_fetch_assoc($RSS);
                    echo json_encode($client);
                } else {
                    // Retorna a lista de clientes
                    $SQL = "SELECT * FROM clientes ORDER BY cd_cliente";
                    $RSS = mysqli_query($conexao, $SQL);
                    $clients = [];
                    while ($row = mysqli_fetch_assoc($RSS)) {
                        $clients[] = $row;
                    }
                    echo json_encode($clients);
                }
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["message" => "Acesso negado. Você não tem permissão."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "ID do usuário não fornecido."]);
        }
        break;  

    case 'POST':
        if ($cd_usuario) {
            $SQL = "SELECT permissao FROM usuario WHERE cd_usuario = $cd_usuario";
            $RSS = mysqli_query($conexao, $SQL);
            $user = mysqli_fetch_assoc($RSS);

            if ($user && $user['permissao'] == 1) {
                // Cria um novo cliente
                $data = json_decode(file_get_contents("php://input"), true);
                $SQL = "INSERT INTO clientes (ds_cliente, ds_email, ds_celular, ds_cidade_cliente, ds_uf_cliente, ds_endereco, ds_bairro, ds_cep, ds_sexo, dt_nascimento, ds_cpf) VALUES (
                    '".addslashes($data['ds_cliente'])."',
                    '".addslashes($data['ds_email'])."',
                    '".addslashes($data['ds_celular'])."',
                    '".addslashes($data['ds_cidade_cliente'])."',
                    '".addslashes($data['ds_uf_cliente'])."',
                    '".addslashes($data['ds_endereco'])."',
                    '".addslashes($data['ds_bairro'])."',
                    '".addslashes($data['ds_cep'])."',
                    '".addslashes($data['ds_sexo'])."',
                    '".addslashes($data['dt_nascimento'])."',
                    '".addslashes($data['ds_cpf'])."'
                )";
                mysqli_query($conexao, $SQL);
                echo json_encode(["message" => "Cliente criado com sucesso."]);
            } else {
                http_response_code(403); // Forbidden
                echo json_encode(["message" => "Acesso negado. Você não tem permissão."]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["message" => "ID do usuário não fornecido."]);
        }
        break;

        case 'PUT':
            if ($cd_usuario) {
                $SQL = "SELECT permissao FROM usuario WHERE cd_usuario = $cd_usuario";
                $RSS = mysqli_query($conexao, $SQL);
                $user = mysqli_fetch_assoc($RSS);
    
                if ($user && $user['permissao'] == 1) {
                    // Atualiza um cliente existente
                    $data = json_decode(file_get_contents("php://input"), true);
                    $SQL = "UPDATE clientes SET
                        ds_cliente='".addslashes($data['ds_cliente'])."',
                        ds_email='".addslashes($data['ds_email'])."',
                        ds_celular='".addslashes($data['ds_celular'])."',
                        ds_cidade_cliente='".addslashes($data['ds_cidade_cliente'])."',
                        ds_uf_cliente='".addslashes($data['ds_uf_cliente'])."',
                        ds_endereco='".addslashes($data['ds_endereco'])."',
                        ds_bairro='".addslashes($data['ds_bairro'])."',
                        ds_cep='".addslashes($data['ds_cep'])."',
                        ds_sexo='".addslashes($data['ds_sexo'])."',
                        dt_nascimento='".addslashes($data['dt_nascimento'])."',
                        ds_cpf='".addslashes($data['ds_cpf'])."'
                        WHERE cd_cliente = $cd_cliente";
                    mysqli_query($conexao, $SQL);
                    echo json_encode(["message" => "Cliente atualizado com sucesso."]);
                } else {
                    http_response_code(403); // Forbidden
                    echo json_encode(["message" => "Acesso negado. Você não tem permissão."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "ID do usuário não fornecido."]);
            }
            break;
    
        case 'DELETE':
            if ($cd_usuario) {
                $SQL = "SELECT permissao FROM usuario WHERE cd_usuario = $cd_usuario";
                $RSS = mysqli_query($conexao, $SQL);
                $user = mysqli_fetch_assoc($RSS);
    
                if ($user && $user['permissao'] == 1) {
                    // Exclui um cliente
                    if ($cd_cliente) {
                        $SQL = "DELETE FROM clientes WHERE cd_cliente = $cd_cliente";
                        mysqli_query($conexao, $SQL);
                        echo json_encode(["message" => "Cliente excluído com sucesso."]);
                    } else {
                        http_response_code(400); // Bad Request
                        echo json_encode(["message" => "ID do cliente não fornecido."]);
                    }
                } else {
                    http_response_code(403); // Forbidden
                    echo json_encode(["message" => "Acesso negado. Você não tem permissão."]);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["message" => "ID do usuário não fornecido."]);
            }
            break;
    
        default:
            echo json_encode(["message" => "Método não permitido."]);
            break;
    }
    ?>