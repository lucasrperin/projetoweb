<?php
include "conecta.php";
$cd_veiculo = $_REQUEST["cd_veiculo"];
$acao       = $_REQUEST["acao"];

if ($acao == "excluir")
{
	$SQL = "delete from veiculos where cd_veiculo= $cd_veiculo ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_veiculo'>";
}

if ($acao == "salvar")
{
	$SQL = "select * from veiculos where cd_veiculo= $cd_veiculo ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS); 	
	If ( $RSX["cd_veiculo"] == $cd_veiculo )
	{
		$SQL  = "update veiculos set ds_veiculo='".addslashes($_REQUEST['ds_veiculo'])."',";
		$SQL .= "ds_placa='".addslashes($_REQUEST['ds_placa'])."',	 ";
    $SQL .= "ds_cor='".addslashes($_REQUEST['ds_cor'])."',	 ";
    $SQL .= "ds_ano='".addslashes($_REQUEST['ds_ano'])."',	 ";
		$SQL .= "ds_modelo='".addslashes($_REQUEST['ds_modelo'])."' ";
		$SQL .= "where cd_veiculo = '". $RSX["cd_veiculo"]."'";
		// echo $SQL;
		$RSS = mysqli_query($conexao,$SQL) or print($SQL);  
		// echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} 
	else
	{
		$SQL  = "Insert into veiculos (ds_veiculo, ds_placa, ds_cor, ds_ano, ds_modelo) "   ; 
		$SQL .= "VALUES ('".addslashes($_REQUEST['ds_veiculo'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_placa'])."',";
    $SQL .= "'".addslashes($_REQUEST['ds_cor'])."',";
    $SQL .= "'".addslashes($_REQUEST['ds_ano'])."',";
		$SQL .= "'".addslashes($_REQUEST['ds_modelo'])."')";
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from veiculos order by cd_veiculo desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$cd_veiculo = $RSX["cd_veiculo"];
		// echo "<script>alert('Registro Inserido.');</script>";
	}
} 

$SQL = "Select * from veiculos where cd_veiculo = $cd_veiculo";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center">
      <h2>Cadastro do Veículo Nº <?php echo $cd_veiculo; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden'   name='cd_veiculo' id='cd_veiculo' value="<?php echo $cd_veiculo; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_veiculo'>
          <div class="row g-3">
            <div class="col-sm-9">
              <label for="firstName" class="form-label">Veículo</label>
              <input type="text" class="form-control" id="ds_veiculo" name="ds_veiculo" placeholder="Seu Veículo" value="<?php echo $RS["ds_veiculo"]; ?>" required>
              <div class="invalid-feedback">
                Nome do Veículo é exigido.
              </div>
            </div>

            <div class="col-sm-3">
              <label for="lastName" class="form-label">Placa</label>
              <input type="text" class="form-control" id="ds_placa" name="ds_placa" placeholder="Sua Placa" value="<?php echo $RS["ds_placa"]; ?>" required>
            </div>

            <div class="col-sm-4">
              <label for="lastName" class="form-label">Cor</label>
              <input type="text" class="form-control" id="ds_cor" name="ds_cor" placeholder="Sua Cor" value="<?php echo $RS["ds_cor"]; ?>" required>
            </div>

            <div class="col-sm-4">
              <label for="lastName" class="form-label">Ano</label>
              <input type="text" class="form-control" id="ds_ano" name="ds_ano" placeholder="Seu Ano" value="<?php echo $RS["ds_ano"]; ?>" required>
            </div>

            <div class="col-4">
              <label for="unidade" class="form-label">Modelo <span class="text-muted"></span></label>
              <input type="unidade" class="form-control" id="ds_modelo" name="ds_modelo" placeholder="Seu Modelo" value="<?php echo $RS["ds_modelo"]; ?>">
            </div>

          </div>
          <hr class="my-4">

          <div class="row g-5">
            <div class="col-6">
              <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar os dados</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_veiculo&cd_veiculo=<?php echo $cd_veiculo;?>","_self");' >Excluir</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?modulo=cadastro_veiculo&cd_veiculo=0","_self");' >Novo</button>
            </div>
        </form>
      </div>
    </div>
  </main>
  <script src="form-validation.js"></script>