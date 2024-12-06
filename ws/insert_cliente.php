<?php 

// Obtendo o JSON do endpoint
$json = file_get_contents("http://192.168.0.100/chamados3/usuarios_json.php");

// Diagnóstico: Verificar o conteúdo do JSON recebido
if ($json === false) {
    die('Erro ao acessar o endpoint');
}

// Exibir o JSON recebido para identificar problemas
echo "<pre>JSON recebido:\n" . htmlspecialchars($json) . "</pre>";

// Decodificando o JSON
$obj = json_decode($json);

// Diagnóstico: Verificar se houve erro na decodificação
if (json_last_error() != 0) {
    echo 'OCORREU UM ERRO!</br>';
    echo 'Erro: ' . json_last_error_msg(); // Mostra a mensagem detalhada do erro
    exit; // Encerra o script em caso de erro no JSON
}

// Se o JSON for válido, continue com o processamento
if (count($obj) > 0) {
    $cone = mysqli_connect("localhost", "root", "", "projetoweb1"); 
    mysqli_set_charset($cone, "utf8");

    $i = 0;
    echo "<br>Dados do Json: ".count($obj)."<br><table>";

    while ($i < count($obj)) {
        $username = mysqli_real_escape_string($cone, $obj[$i]->username); // Escapar valor

        // Montar a query corretamente
        $SQL  = "INSERT INTO clientes (ds_cliente) VALUES ('$username')";

        if ($cone->query($SQL) === TRUE) {
            echo "<tr><td>Inserido: $username</td></tr>";
        } else {
            echo "<tr><td>Erro ao inserir: " . $cone->error . "</td></tr>";
        }

        $i++;
    }
    echo "</table>";
    echo "$i inseridos";
} else {
    echo "Json Vazio ou com Problema";
}
?>
