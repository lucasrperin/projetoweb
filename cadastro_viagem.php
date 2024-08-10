<?php
include "conecta.php";
$cd_viagem = isset($_REQUEST["cd_viagem"]) ? $_REQUEST["cd_viagem"] : 0;
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "excluir")
{
    $SQL = "delete from viagens where cd_viagem= $cd_viagem ";
    $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error($conexao));
    echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_viagens'>";
}

if ($acao == "salvar")
{
    $SQL = "select * from viagens where cd_viagem= $cd_viagem ";
    $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error($conexao));
    
    if ($RSX = mysqli_fetch_assoc($RSS)) 
    {   
        $SQL  = "update viagens set ds_origem='".str_replace("'","",$_REQUEST['ds_origem'])."',";
        $SQL .= "ds_destino='".str_replace("'","",$_REQUEST['ds_destino'])."',";
        $SQL .= "ds_placa_viagem='".str_replace("'","",$_REQUEST['ds_placa_viagem'])."',";
        $SQL .= "ds_carga='".str_replace("'","",$_REQUEST['ds_carga'])."',";
        $SQL .= "ds_valor='".str_replace("'","",$_REQUEST['ds_valor'])."',";
        $SQL .= "dt_inicio='".str_replace("'","",$_REQUEST['dt_inicio'])."',";
        $SQL .= "dt_fim='".str_replace("'","",$_REQUEST['dt_fim'])."' ";
        $SQL .= "where cd_viagem = '". $RSX["cd_viagem"]."'";
        $RSS = mysqli_query($conexao,$SQL) or print(mysqli_error($conexao));  
    } 
    else 
    {
        $SQL  = "Insert into viagens (ds_origem, ds_destino, ds_placa_viagem, ds_carga, ds_valor, dt_inicio, dt_fim) "; 
        $SQL .= "VALUES ('".str_replace("'","",$_REQUEST['ds_origem'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['ds_destino'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['ds_placa_viagem'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['ds_carga'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['ds_valor'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['dt_inicio'])."',";
        $SQL .= "'".str_replace("'","",$_REQUEST['dt_fim'])."')";
        $RSS = mysqli_query($conexao,$SQL) or die(mysqli_error($conexao));

        $SQL = "select * from viagens order by cd_viagem desc limit 1";
        $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error($conexao));
        $RSX = mysqli_fetch_assoc($RSS); 
        $cd_viagem = $RSX["cd_viagem"];
    }
} 

$SQL = "Select * from viagens where cd_viagem = $cd_viagem";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error($conexao));
$RS = mysqli_fetch_assoc($RSS);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center d-flex justify-content-between align-items-center">
        <a href="menu.php?modulo=listagem_viagens" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <h2 class="h2 flex-grow-1 text-center">Cadastro Nº <?php echo $cd_viagem; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden' name='cd_viagem'  id='cd_viagem'  value="<?php echo $cd_viagem; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_viagem'>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Origem</label>
              <input type="text" class="form-control" id="ds_origem" name="ds_origem" placeholder="Local de Origem" value="<?php echo isset($RS["ds_origem"]) ? $RS["ds_origem"] : ''; ?>" required>
              <div class="invalid-feedback">
                Local de Origem é obrigatório.
              </div>
            </div>
			
			<div class="col-sm-6">
              <label for="firstName" class="form-label">Destino</label>
              <input type="text" class="form-control" id="ds_destino" name="ds_destino" placeholder="Local de Destino" value="<?php echo isset($RS["ds_destino"]) ? $RS["ds_destino"] : ''; ?>" required>
              <div class="invalid-feedback">
                Local de Destino é obrigatório.
              </div>
            </div>
            </div>
			
			<div class="row g-3">
				<div class="col-sm-3">
				  <label for="firstName" class="form-label">Placa</label>
				  <select name='ds_placa_viagem' id='ds_placa_viagem' class="form-control">
					<?
					$SQL = "select * from veiculos order by ds_placa";
					$RRR = mysqli_query($conexao,$SQL)or print(mysqli_error($conexao));
					while($RR = mysqli_fetch_array($RRR))
					{
						echo "<option value='".$RR["ds_placa"]."' ";
						if (isset($RS["ds_placa_viagem"]) && $RS["ds_placa_viagem"] == $RR["ds_placa"]) { 
                            echo " SELECTED "; 
                        }
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
				  <input type="text" class="form-control" id="ds_carga" name="ds_carga" placeholder="Carga" value="<?php echo isset($RS["ds_carga"]) ? $RS["ds_carga"] : ''; ?>" required>
				  <div class="invalid-feedback">
					A carga é obrigatória.
				  </div>
				</div>
			
				<div class="col-sm-3">
				  <label for="firstName" class="form-label">Valor</label>
				  <input type="text" class="form-control" id="ds_valor" name="ds_valor" placeholder="Valor" value="<?php echo isset($RS["ds_valor"]) ? $RS["ds_valor"] : ''; ?>" required>
				  <div class="invalid-feedback">
					O valor é obrigatório.
				  </div>
				</div>
			</div>
			
			<div class="row g-3">	
				<div class="col-sm-2">
				  <label for="firstName" class="form-label">Início</label>
				  <input type="date" class="form-control" id="dt_inicio" name="dt_inicio" placeholder="Início" value="<?php echo isset($RS["dt_inicio"]) ? $RS["dt_inicio"] : ''; ?>" unrequired>
				</div>
				
				<div class="col-sm-2">
				  <label for="firstName" class="form-label">Fim</label>
				  <input type="date" class="form-control" id="dt_fim" name="dt_fim" placeholder="Fim" value="<?php echo isset($RS["dt_fim"]) ? $RS["dt_fim"] : '';  ?>" unrequired>
				</div>
			</div>
          </div>
          <hr class="my-4">
          	<div class="col-2">
              <button class="btn btn-sm btn-primary" type="submit" >Salvar</button>
              <button class="btn btn-sm btn-primary" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_viagem&cd_viagem=<?php echo $cd_viagem;?>","_self");' >Excluir</button> 
			</div>
			</form>
		</div>
    </div>
  </main>
  <script src="form-validation.js"></script>