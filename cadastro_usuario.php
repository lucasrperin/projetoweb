<?php
include "conecta.php";
$cd_usuario = $_REQUEST["cd_usuario"];
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "excluir")
{
	$SQL = "delete from usuarios where cd_usuario= $cd_usuario ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_usuario'>";
}

if ($acao == "salvar")
{
	$SQL = "select * from usuarios where cd_usuario= $cd_usuario ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS); 	
	If ( $RSX["cd_usuario"] == $cd_usuario )
	{
		$SQL  = "update usuarios set ds_usuario='".str_replace("'","",$_REQUEST['ds_usuario'])."',";
		$SQL .= "ds_email='".str_replace("'","",$_REQUEST['ds_email'])."',	 ";
		$SQL .= "ds_senha='".str_replace("'","",$_REQUEST['ds_senha'])."' ";
		$SQL .= "where cd_usuario = '". $RSX["cd_usuario"]."'";
		$RSS = mysqli_query($conexao,$SQL) or print($SQL);  
		// echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} 
	else
	{
		$SQL  = "Insert into usuarios (ds_usuario,ds_email,ds_senha) "   ; 
		$SQL .= "VALUES ('".str_replace("'","",$_REQUEST['ds_usuario'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_email'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_senha'])."')";
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from usuarios order by cd_usuario desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$cd_usuario = $RSX["cd_usuario"];
		// echo "<script>alert('Registro Inserido.');</script>";
	}
} 

$SQL = "Select * from usuarios where cd_usuario = $cd_usuario";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center">
      <h2>Cadastro de Usuário Nº <?php echo $cd_usuario; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden'   name='cd_usuario' id='cd_usuario' value="<?php echo $cd_usuario; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_usuario'>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Usuario</label>
              <input type="text" class="form-control" id="ds_usuario" name="ds_usuario" placeholder="seu nome" value="<?php echo $RS["ds_usuario"]; ?>" required>
              <div class="invalid-feedback">
                Nome do usuário é exigido.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Senha</label>
              <input type="text" class="form-control" id="ds_senha" name="ds_senha" placeholder="sua senha" value="<?php echo $RS["ds_senha"]; ?>" required>
              <div class="invalid-feedback">
                Senha do usuário é exigida.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="email@email.com" value="<?php echo $RS["ds_email"]; ?>">
              <div class="invalid-feedback">
                Insira um email válido.
              </div>
            </div>

          </div>
          <hr class="my-4">

          <div class="row g-5">
            <div class="col-6">
              <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar os dados</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_usuario&cd_usuario=<?php echo $cd_usuario;?>","_self");' >Excluir</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?modulo=cadastro_usuario&cd_usuario=0","_self");' >Novo</button>
            </div>
        </form>
      </div>
    </div>
  </main>
  <script src="form-validation.js"></script>