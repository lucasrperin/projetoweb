<?php
include "conecta.php";
$cd_produto = $_REQUEST["cd_produto"];
$acao       = $_REQUEST["acao"];

if ($acao == "excluir")
{
	$SQL = "delete from produtos where cd_produto= $cd_produto ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_produto'>";
}

if ($acao == "salvar")
{
	$SQL = "select * from produtos where cd_produto= $cd_produto ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS); 	
	If ( $RSX["cd_produto"] == $cd_produto )
	{
		$SQL  = "update produtos set ds_produto='".addslashes($_REQUEST['ds_produto'])."',";
		$SQL .= "ds_unidade='".addslashes($_REQUEST['ds_unidade'])."',	 ";
    $SQL .= "ds_categoria='".addslashes($_REQUEST['ds_categoria'])."',	 ";
    $SQL .= "vl_estoque='".addslashes($_REQUEST['vl_estoque'])."',	 ";
    $SQL .= "vl_venda='".addslashes($_REQUEST['vl_venda'])."',	 ";
		$SQL .= "ds_cor='".addslashes($_REQUEST['ds_cor'])."' ";
		$SQL .= "where cd_produto = '". $RSX["cd_produto"]."'";
		// echo $SQL;
		$RSS = mysqli_query($conexao,$SQL) or print($SQL);  
		// echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} 
	else
	{
		$SQL  = "Insert into produtos (ds_produto,ds_unidade,ds_categoria,vl_estoque, vl_venda, ds_cor) "   ; 
		$SQL .= "VALUES ('".addslashes($_REQUEST['ds_produto'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_unidade'])."',";
    $SQL .= "'".addslashes($_REQUEST['ds_categoria'])."',";
    $SQL .= "'".addslashes($_REQUEST['vl_estoque'])."',";
    $SQL .= "'".addslashes($_REQUEST['vl_venda'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_cor'])."')";
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from produtos order by cd_produto desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$cd_produto = $RSX["cd_produto"];
		// echo "<script>alert('Registro Inserido.');</script>";
	}
} 

$SQL = "Select * from produtos where cd_produto = $cd_produto";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center">
      <h2>Cadastro do Produto Nº <?php echo $cd_produto; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden'   name='cd_produto' id='cd_produto' value="<?php echo $cd_produto; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_produto'>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Produto</label>
              <input type="text" class="form-control" id="ds_produto" name="ds_produto" placeholder="seu nome" value="<?php echo $RS["ds_produto"]; ?>" required>
              <div class="invalid-feedback">
                Nome do produto é exigido.
              </div>
            </div>

            <div class="col-sm-3">
              <label for="lastName" class="form-label">Quantidade</label>
              <input type="text" class="form-control" id="vl_estoque" name="vl_estoque" placeholder="Quantidade" value="<?php echo $RS["vl_estoque"]; ?>" required>
            </div>

            <div class="col-sm-3">
              <label for="valor" class="form-label">Valor <span class="text-muted"></span></label>
              <input type="text" class="form-control" id="vl_venda" name="vl_venda" placeholder="R$" value="<?php echo $RS["vl_venda"]; ?>">
            </div>

            <div class="col-sm-4">
              <label for="lastName" class="form-label">Cor</label>
              <input type="text" class="form-control" id="ds_cor" name="ds_cor" placeholder="Sua cor" value="<?php echo $RS["ds_cor"]; ?>" required>
            </div>

            <div class="col-sm-4">
              <label for="lastName" class="form-label">Categoria</label>
              <input type="text" class="form-control" id="ds_categoria" name="ds_categoria" placeholder="Categoria" value="<?php echo $RS["ds_categoria"]; ?>" required>
            </div>

            <div class="col-4">
              <label for="unidade" class="form-label">Unidade <span class="text-muted"></span></label>
              <input type="unidade" class="form-control" id="ds_unidade" name="ds_unidade" placeholder="unidade@unidade.com" value="<?php echo $RS["ds_unidade"]; ?>">
            </div>


          </div>
          <hr class="my-4">

          <div class="row g-5">
            <div class="col-6">
              <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar os dados</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_produto&cd_produto=<?php echo $cd_produto;?>","_self");' >Excluir</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?modulo=cadastro_produto&cd_produto=0","_self");' >Novo</button>
            </div>
        </form>
      </div>
    </div>
  </main>
  <script src="form-validation.js"></script>