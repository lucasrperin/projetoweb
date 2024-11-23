<?php
include "conecta.php";
$cd_usuario = $_REQUEST["cd_usuario"];
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "excluir") {
    $SQL = "DELETE FROM usuarios WHERE cd_usuario = $cd_usuario";
    $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error($conexao));
    echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_usuario'>";
}

if ($acao == "salvar") {
    $permissao = isset($_REQUEST['permissao']) ? 1 : 0;
    
    // Verifica se a senha foi informada
    if (!empty($_REQUEST['ds_senha'])) {
        $senha_hash = password_hash($_REQUEST['ds_senha'], PASSWORD_DEFAULT); // Criptografa a senha
    } else {
        $senha_hash = null; // Define a senha como null caso esteja vazia
    }

    $SQL = "SELECT * FROM usuarios WHERE cd_usuario = $cd_usuario";
    $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error($conexao));
    $RSX = mysqli_fetch_assoc($RSS);

    if ($RSX["cd_usuario"] == $cd_usuario) {
        $SQL  = "UPDATE usuarios SET 
            ds_usuario = '" . str_replace("'", "", $_REQUEST['ds_usuario']) . "',
            ds_email = '" . str_replace("'", "", $_REQUEST['ds_email']) . "',";
        // Verifica se a senha está vazia antes de incluir
        if ($senha_hash !== null) {
            $SQL .= "ds_senha = '$senha_hash',";
        }
        $SQL .= "permissao = $permissao
            WHERE cd_usuario = '" . $RSX["cd_usuario"] . "'";
        $RSS = mysqli_query($conexao, $SQL) or print($SQL);
    } else {
        $SQL  = "INSERT INTO usuarios (ds_usuario, ds_email, ds_senha, permissao) VALUES (
            '" . str_replace("'", "", $_REQUEST['ds_usuario']) . "',
            '" . str_replace("'", "", $_REQUEST['ds_email']) . "',";
        // Verifica se a senha está vazia antes de incluir
        if ($senha_hash !== null) {
            $SQL .= "'$senha_hash',";
        } else {
            $SQL .= "null,";
        }
        $SQL .= "$permissao
        )";
        $RSS = mysqli_query($conexao, $SQL) or die('Erro ao inserir registro');

        $SQL = "SELECT * FROM usuarios ORDER BY cd_usuario DESC LIMIT 1";
        $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error($conexao));
        $RSX = mysqli_fetch_assoc($RSS);
        $cd_usuario = $RSX["cd_usuario"];
    }
    echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_usuario'>";
    exit;
}

$SQL = "SELECT * FROM usuarios WHERE cd_usuario = $cd_usuario";
$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error($conexao));
$RS = mysqli_fetch_assoc($RSS);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="py-5 text-center d-flex justify-content-between align-items-center">
      <a href="menu.php?modulo=listagem_usuario" class="btn btn-sm btn-primary">
          <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <h2 class="h2 flex-grow-1 text-center">Cadastro Nº <?php echo $cd_usuario; ?> </h2>
  </div>
    <div class="row g-5">
        <div class="col-md-12 col-lg-12">
            <form class="needs-validation" novalidate action="menu.php">
                <input type='hidden' name='cd_usuario' id='cd_usuario' value="<?php echo $cd_usuario; ?>">
                <input type='hidden' name='acao' id='acao' value='salvar'>
                <input type='hidden' name='modulo' id='modulo' value='cadastro_usuario'>
                <div class="row g-3">
                    <div class="col-sm-2">
                        <label for="ds_usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="ds_usuario" name="ds_usuario" placeholder="Seu nome" value="<?php echo $RS["ds_usuario"]; ?>" required>
                        <div class="invalid-feedback">
                            Nome do usuário é exigido.
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <label for="ds_senha" class="form-label">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="ds_senha" name="ds_senha" placeholder="Sua senha" unrequired>
                            <button class="btn btn-outline-secondary" type="button" id="toggleSenha">
                                <i class="fas fa-eye" id="iconeSenha"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">
                            Senha do usuário é exigida.
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="ds_email" class="form-label">Email <span class="text-muted">(Opcional)</span></label>
                        <input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="email@email.com" value="<?php echo $RS["ds_email"]; ?>">
                        <div class="invalid-feedback">
                            Insira um email válido.
                        </div>
                    </div>

                    <div class="col-2">
                        <label for="permissao" class="form-label">Acessar Web Service</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="permissao" name="permissao" value="1" <?php echo ($RS["permissao"] == 1 ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="permissao">
                                Conceder permissão
                            </label>
                        </div>
                    </div>
                </div>
                <hr class="my-4">

                <div class="col-2">
                    <button class="btn btn-sm btn-primary" type="submit">Salvar</button>
                    <button class="btn btn-sm btn-primary" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_usuario&cd_usuario=<?php echo $cd_usuario;?>","_self");' >Excluir</button>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
  document.getElementById('toggleSenha').addEventListener('click', function () {
      const senhaInput = document.getElementById('ds_senha');
      const iconeSenha = document.getElementById('iconeSenha');

      if (senhaInput.type === 'password') {
          senhaInput.type = 'text';
          iconeSenha.classList.remove('fa-eye');
          iconeSenha.classList.add('fa-eye-slash');
      } else {
          senhaInput.type = 'password';
          iconeSenha.classList.remove('fa-eye-slash');
          iconeSenha.classList.add('fa-eye');
      }
  });
</script>
