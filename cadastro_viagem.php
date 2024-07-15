<?php
include "conecta.php";
$cd_viagem = $_REQUEST["cd_viagem"];
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "excluir")
{
	$SQL = "delete from viagens where cd_viagem= $cd_viagem ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_viagens'>";
}

if ($acao == "salvar")
{
	$SQL = "select * from viagens where cd_viagem= $cd_viagem ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS); 	
	If ( $RSX["cd_viagem"] == $cd_viagem )
	{
		$SQL  = "update viagens set ds_origem='".str_replace("'","",$_REQUEST['ds_origem'])."',";
		$SQL .= "ds_destino='".str_replace("'","",$_REQUEST['ds_destino'])."',	 ";
		$SQL .= "ds_placa='".str_replace("'","",$_REQUEST['ds_placa'])."',	 ";
		$SQL .= "ds_carga='".str_replace("'","",$_REQUEST['ds_carga'])."',	 ";
		$SQL .= "ds_valor='".str_replace("'","",$_REQUEST['ds_valor'])."',	 ";
		$SQL .= "dt_inicio='".str_replace("'","",$_REQUEST['dt_inicio'])."',	 ";
		$SQL .= "dt_fim='".str_replace("'","",$_REQUEST['dt_fim'])."' ";
		$SQL .= "where cd_viagem = '". $RSX["cd_viagem"]."'";
		$RSS = mysqli_query($conexao,$SQL) or print($SQL);  
		// echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} 
	else
	{
		$SQL  = "Insert into viagens (ds_origem,ds_destino,ds_placa,ds_carga,ds_valor,dt_inicio,dt_fim) "   ; 
		$SQL .= "VALUES ('".str_replace("'","",$_REQUEST['ds_origem'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_destino'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_placa'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_carga'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['ds_valor'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['dt_inicio'])."',";
		$SQL .= "'".str_replace("'","",$_REQUEST['dt_fim'])."')";
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from viagens order by cd_viagem desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$cd_viagem = $RSX["cd_viagem"];
		// echo "<script>alert('Registro Inserido.');</script>";
	}
} 

$SQL = "Select * from viagens where cd_viagem = $cd_viagem";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center">
      <h2>Viagem Nº <?php echo $cd_viagem; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden'   name='cd_viagem' id='cd_viagem' value="<?php echo $cd_viagem; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_viagem'>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Origem</label>
              <input type="text" class="form-control" id="ds_origem" name="ds_origem" placeholder="Local de Origem" value="<?php echo $RS["ds_origem"]; ?>" required>
              <div class="invalid-feedback">
                Local de Origem é obrigatório.
              </div>
            </div>
			
			<div class="col-sm-6">
              <label for="firstName" class="form-label">Destino</label>
              <input type="text" class="form-control" id="ds_destino" name="ds_destino" placeholder="Local de Destino" value="<?php echo $RS["ds_destino"]; ?>" required>
              <div class="invalid-feedback">
                Local de Destino é obrigatório.
              </div>
            </div>
            </div>
			
			<div class="row g-3">
				<div class="col-sm-3">
				  <label for="firstName" class="form-label">Placa</label>
				  <select name='ds_placa' id='ds_placa' class="form-control">
					<?
					$SQL = "select * from veiculos order by ds_placa";
					$RRR = mysqli_query($conexao,$SQL)or print(mysqli_error());
					while($RR = mysqli_fetch_array($RRR))
					{
						echo "<option value='".$RR["cd_veiculo"]."' ";
						if ($RS["ds_placa"]==$RR["cd_veiculo"]) { echo " SELECTED "; }
						echo ">".$RR["ds_placa"]."</option>";
					}
					?>
					</select>
				  <div class="invalid-feedback">
					A placa é obrigatória.
				  </div>
				</div>
				
				<div class="col-sm-3">
				  <label for="firstName" class="form-label">Carga</label>
				  <input type="text" class="form-control" id="ds_carga" name="ds_carga" placeholder="Carga" value="<?php echo $RS["ds_carga"]; ?>" required>
				  <div class="invalid-feedback">
					A carga é obrigatória.
				  </div>
				</div>
			
				<div class="col-sm-3">
				  <label for="firstName" class="form-label">Valor</label>
				  <input type="text" class="form-control" id="ds_valor" name="ds_valor" placeholder="Valor" value="<?php echo $RS["ds_valor"]; ?>" required>
				  <div class="invalid-feedback">
					O valor é obrigatório.
				  </div>
				</div>
			</div>
			
			<div class="row g-3">	
				<div class="col-sm-6">
				  <label for="firstName" class="form-label">Início</label>
				  <input type="text" class="form-control" id="dt_inicio" name="dt_inicio" placeholder="Início" value="<?php echo $RS["dt_inicio"]; ?>" unrequired>
				</div>
				
				<div class="col-sm-6">
				  <label for="firstName" class="form-label">Fim</label>
				  <input type="text" class="form-control" id="dt_fim" name="dt_fim" placeholder="Fim" value="<?php echo $RS["dt_fim"]; ?>" unrequired>
				</div>
			</div>
			
          </div>
          <hr class="my-4">

          <div class="row g-5">
            <div class="col-6">
              <button class="w-100 btn btn-primary btn-lg" type="submit" >Salvar os dados</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_viagem&cd_viagem=<?php echo $cd_viagem;?>","_self");' >Excluir</button>
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?modulo=cadastro_viagem&cd_viagem=0","_self");' >Novo</button>
            </div>
        </form>
      </div>
    </div>
  </main>
  <script src="form-validation.js"></script>