<?php
include "conecta.php";
$cd_cliente = intval($_REQUEST["cd_cliente"]);
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "excluir")
{
	$SQL = "delete from clientes where cd_cliente= $cd_cliente ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_cliente'>";
}

if ($acao == "salvar")
{
	$SQL = "select * from clientes where cd_cliente= $cd_cliente ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS);
  if ($RSX && $RSX["cd_cliente"] == $cd_cliente)
	{
		$SQL  = "update clientes set ds_cliente='".addslashes($_REQUEST['ds_cliente'])."',";
		$SQL .= "ds_email='".addslashes($_REQUEST['ds_email'])."',	 ";
		$SQL .= "ds_celular='".addslashes($_REQUEST['ds_celular'])."', ";
    $SQL .= "ds_cidade_cliente='".addslashes($_REQUEST['ds_cidade_cliente'])."', ";
    $SQL .= "ds_uf_cliente='".addslashes($_REQUEST['ds_uf_cliente'])."', ";
    $SQL .= "ds_endereco='".addslashes($_REQUEST['ds_endereco'])."', ";
    $SQL .= "ds_bairro='".addslashes($_REQUEST['ds_bairro'])."', ";
    $SQL .= "ds_cep='".addslashes($_REQUEST['ds_cep'])."', ";
    $SQL .= "ds_sexo='".addslashes($_REQUEST['ds_sexo'])."', ";
    $SQL .= "dt_nascimento='".$_REQUEST['dt_nascimento']."', ";
    $SQL .= "ds_cpf='".addslashes($_REQUEST['ds_cpf'])."' ";
		$SQL .= "where cd_cliente = '". $RSX["cd_cliente"]."'";
	// 	echo $SQL;
		$RSS = mysqli_query($conexao,$SQL) or print($SQL);  
	} 
	else
	{
		$SQL  = "Insert into clientes (ds_cliente,ds_email,ds_celular,ds_cidade_cliente,ds_uf_cliente,ds_endereco,ds_bairro,ds_cep,ds_sexo,dt_nascimento,ds_cpf) "   ; 
		$SQL .= "VALUES ('".addslashes($_REQUEST['ds_cliente'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_email'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_celular'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_cidade_cliente'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_uf_cliente'])."',";        
    $SQL .= "'".addslashes($_REQUEST['ds_endereco'])."',";   
    $SQL .= "'".addslashes($_REQUEST['ds_bairro'])."',";   
    $SQL .= "'".addslashes($_REQUEST['ds_cep'])."',";   
    $SQL .= "'".addslashes($_REQUEST['ds_sexo'])."',";   
    $SQL .= "'".addslashes($_REQUEST['dt_nascimento'])."',";   
    $SQL .= "'".addslashes($_REQUEST['ds_cpf'])."')";   
    // echo $SQL;
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from clientes order by cd_cliente desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$cd_cliente = $RSX["cd_cliente"];
	}
} 

$SQL = "Select * from clientes where cd_cliente = $cd_cliente";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center d-flex justify-content-between align-items-center">
        <a href="menu.php?modulo=listagem_cliente" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <h2 class="h2 flex-grow-1 text-center">Cadastro Nº <?php echo $cd_cliente; ?> </h2>
    </div>
    <div class="row g-5">
        <div class="col-md-12 col-lg-12">
            <form class="needs-validation" novalidate action="menu.php">
                <input type='hidden' name='cd_cliente' id='cd_cliente' value="<?php echo $cd_cliente; ?>">
                <input type='hidden' name='acao' id='acao' value='salvar'>
                <input type='hidden' name='modulo' id='modulo' value='cadastro_cliente'>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Cliente</label>
                        <input type="text" class="form-control" id="ds_cliente" name="ds_cliente" placeholder="seu nome" value="<?php echo isset($RS['ds_cliente']) ? $RS['ds_cliente'] : ''; ?>" required>
                        <div class="invalid-feedback">
                            Nome do cliente é exigido.
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="cpf" class="form-label">CPF <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_cpf" name="ds_cpf" placeholder="cpf" value="<?php echo isset($RS['ds_cpf']) ? $RS['ds_cpf'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um CPF válido.
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <label for="lastName" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="ds_celular" name="ds_celular" placeholder="Celular cliente" value="<?php echo isset($RS['ds_celular']) ? $RS['ds_celular'] : ''; ?>" required>
                        <div class="invalid-feedback">
                            Celular do cliente é exigida.
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="email@email.com" value="<?php echo isset($RS['ds_email']) ? $RS['ds_email'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um email válido.
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="endereco" class="form-label">Endereço <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_endereco" name="ds_endereco" placeholder="endereço" value="<?php echo isset($RS['ds_endereco']) ? $RS['ds_endereco'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um endereço válido.
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="bairro" class="form-label">Bairro <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_bairro" name="ds_bairro" placeholder="bairro" value="<?php echo isset($RS['ds_bairro']) ? $RS['ds_bairro'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um bairro válido.
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="Cidade" class="form-label">Cidade <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_cidade_cliente" name="ds_cidade_cliente" value="<?php echo isset($RS['ds_cidade_cliente']) ? $RS['ds_cidade_cliente'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira uma Cidade Válida.
                        </div>
                    </div>
                    <div class="col-1">
                        <label for="cep" class="form-label">CEP <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_cep" name="ds_cep" placeholder="cep" value="<?php echo isset($RS['ds_cep']) ? $RS['ds_cep'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um CEP válido.
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="sexo" class="form-label">Sexo <span class="text-muted"></span></label>
                        <input type="text" class="form-control" id="ds_sexo" name="ds_sexo" placeholder="sexo" value="<?php echo isset($RS['ds_sexo']) ? $RS['ds_sexo'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um sexo válido.
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="Nascimento" class="form-label">Nascimento <span class="text-muted"></span></label>
                        <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?php echo isset($RS['dt_nascimento']) ? $RS['dt_nascimento'] : ''; ?>">
                        <div class="invalid-feedback">
                            Insira um nascimento válido.
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="col-2">
                    <button class="btn btn-primary btn-sm btn"" type="submit">Salvar</button>
                    <button class="btn btn-primary btn-sm btn"" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_cliente&cd_cliente=<?php echo $cd_cliente; ?>", "_self");'>Excluir</button>
                </div>
            </form>
        </div>
    </div>
</main>
  <script src="form-validation.js"></script>