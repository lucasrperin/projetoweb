<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebService</title>
    <link rel="stylesheet" href="ws.css"> <!-- Referência ao ws.css -->
</head>
<body>
    <main class="topo">
        <div class="title">
            <h1 class="h2">Conexões</h1>
        </div>
        <table id="example" style="width:100%">
            <thead>
                <tr>
                    <th>IP</th>
                    <th>Data e Hora</th>
                    <th>Mensagem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Caminho para o arquivo de log
                $arquivoLog = __DIR__ . '\ws\acesso_log.txt'; 


                // Verifica se o arquivo existe e está acessível
                if (file_exists($arquivoLog) && is_readable($arquivoLog)) {
                    // Lê o arquivo de log
                    $linhas = file($arquivoLog);
                    
                    // Itera sobre cada linha do arquivo
                    foreach ($linhas as $linha) {
                        // Extrai os dados da linha
                        preg_match('/\[(.+?)\] - IP: (.+?) - (.+)/', $linha, $matches);
                        if (count($matches) === 4) {
                            $dataHora = $matches[1];
                            $ip = $matches[2];
                            $mensagem = $matches[3];

                            // Exibe os dados em uma nova linha da tabela
                            echo "<tr>
                                    <td>$ip</td>
                                    <td>$dataHora</td>
                                    <td>$mensagem</td>
                                  </tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='4'>Não foi possível acessar o arquivo de log.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
