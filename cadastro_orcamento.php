<?php
include "conecta.php";
$cd_orcamento = isset($_REQUEST["cd_orcamento"]) ? $_REQUEST["cd_orcamento"] : 0;
$cd_produto = $acao = isset($_GET['cd_produto']) ? $_GET['cd_produto'] : '';
$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

if ($acao == "insere_produto")
{
	$SQL = "insert into orcamento_itens (cd_orcamento_oi,cd_produto_oi) values ($cd_orcamento,$cd_produto)";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
}
if ($acao == "remove_produto")
{
	$SQL = "delete from orcamento_itens where cd_orcamento_oi = $cd_orcamento and cd_produto_oi=$cd_produto";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
}

if ($acao == "excluir")
{
	$SQL = "delete from orcamentos where cd_orcamento= $cd_orcamento ";
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
  echo "<meta http-equiv='refresh' content='0; url=menu.php?modulo=listagem_orcamento'>";
}

if ($acao == "salvar")
{
    $SQL = "select * from orcamentos where cd_orcamento= $cd_orcamento ";
    $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
    $RSX = mysqli_fetch_assoc($RSS); 	
    if ($RSX["cd_orcamento"] == $cd_orcamento)
    {
        $SQL  = "update orcamentos set ";
        $SQL .= "cd_cliente_orcamento='".$_REQUEST['cd_cliente_orcamento']."',";
        $SQL .= "vl_valor=".$_REQUEST['vl_valor']." ";
        $SQL .= "where cd_orcamento = '". $RSX["cd_orcamento"]."'";
        $RSS = mysqli_query($conexao,$SQL) or print($SQL);  
    } 
    else
    {
        $SQL  = "Insert into orcamentos (dt_orcamento,cd_usuario_orcamento,cd_cliente_orcamento,vl_valor) "; 
        $SQL .= "VALUES (now(),1,".$_REQUEST['cd_cliente_orcamento'].",".$_REQUEST['vl_valor'].")";
        $RSS = mysqli_query($conexao,$SQL) or die('erro');

        $SQL = "select * from orcamentos order by cd_orcamento desc limit 1";
        $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
        $RSX = mysqli_fetch_assoc($RSS); 
        $cd_orcamento = $RSX["cd_orcamento"];
    }

    // Redirecionar após um pequeno delay
    echo "<script>
        setTimeout(function(){
            window.location.href = 'menu.php?modulo=listagem_orcamento';
        }, 500); // 500ms de atraso
    </script>";
}

$SQL = "Select * from orcamentos where cd_orcamento = $cd_orcamento";
$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="py-5 text-center d-flex justify-content-between align-items-center">
        <a href="menu.php?modulo=listagem_orcamento" class="btn btn-sm btn-primary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <h2 class="h2 flex-grow-1 text-center">Orçamento Nº <?php echo $cd_orcamento; ?> </h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <form class="needs-validation" novalidate action="menu.php">
          <input type='hidden'   name='cd_orcamento' id='cd_orcamento' value="<?php echo $cd_orcamento; ?>">
          <input type='hidden' name='acao'       id='acao'       value='salvar'>
          <input type='hidden' name='modulo'     id='modulo'     value='cadastro_orcamento'>
          <div class="row g-3">
            <div class="col-sm-3">
              <label for="firstName" class="form-label">Dia</label>
              <input type="date" class="form-control" id="dt_orcamento" name="dt_orcamento" value="<?php echo isset($RS["dt_orcamento"]) ? $RS["dt_orcamento"] : ''; ?>" readonly='true'>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Cliente</label>
              <select name='cd_cliente_orcamento' id='cd_cliente_orcamento' class="form-control">
              <?
               $SQL = "select * from clientes order by ds_cliente";
               $RRR = mysqli_query($conexao,$SQL)or print(mysqli_error());
               while($RR = mysqli_fetch_array($RRR))
               {
                  echo "<option value='".$RR["cd_cliente"]."' ";
                  if (isset($RS["cd_cliente_orcamento"]) && $RS["cd_cliente_orcamento"] ==$RR["cd_cliente"]) { echo " SELECTED "; }
                  echo ">".$RR["ds_cliente"]."</option>";
               }
              ?>
              </select>
            </div>

            <div class="col-3">
              <label for="email" class="form-label">Valor</label>
              <input type="text" class="form-control" id="vl_valor" name="vl_valor" value="<? echo isset($RS["vl_valor"]) ? $RS["vl_valor"] : ''; ?>">
            </div>

          </div>
          <hr class="my-4">

          <div class="row g-5">
            <div class="col-6">
<<<<<<< HEAD
              <button class="w-100 btn btn-primary btn-lg" type="submit" onclick='window.open("menu.php?modulo=listagem_orcamento");'>Salvar os dados</button>
=======
              <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar</button>
>>>>>>> 5667ab61f35663f71952250c8f83d9bb1caca67f
            </div>
            <div class="col-3">
              <button class="w-100 btn btn-primary btn-lg" type="button" onclick='window.open("menu.php?acao=excluir&modulo=cadastro_orcamento&cd_orcamento=<?php echo $cd_orcamento;?>","_self");' >Excluir</button>
            </div>
        </form>
      </div>
    </div>

    <div class="col-md-4 col-lg-4" style='margin:6px;background-color:#EEEEEE;border-radius:9px;'>
    <center><h3 style='font-size:14px;'>Disponíveis </h3></center>
    <table  style="width:100%">        
        <tbody>
        <?
          $SQL = "select * from produtos where cd_produto not in (Select cd_produto_oi from orcamento_itens where cd_orcamento_oi = $cd_orcamento) order by ds_produto";
          $RPP = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RP = mysqli_fetch_array($RPP))
          {
            echo "<tr onClick='seleciona(".$RP["cd_produto"].")' >";
            echo "<td>".$RP["ds_produto"]."</td>";
            echo "<td>".$RP["vl_estoque"]."</td>";
            echo "<td>".$RP["vl_venda"]."</td>";
            echo "</tr>";
          }
        ?>
        </tbody>
    </table>
    </div>

    <div class="col-md-7 col-lg-7" style='margin:6px;background-color:#EEEEEE;border-radius:9px;'>
    <center><h3 style='font-size:14px;'>Selecionados </h3></center>
    <table  style="width:100%">        
        <tbody>
        <?
          $SQL = "select * from orcamento_itens,produtos where cd_orcamento_oi = $cd_orcamento and cd_produto_oi=cd_produto order by ds_produto";
          $RPP = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RP = mysqli_fetch_array($RPP))
          {
            echo "<tr onClick='removendo(".$RP["cd_produto"].")' >";
            echo "<td>".$RP["ds_produto"]."</td>";
            echo "<td>".$RP["vl_estoque"]."</td>";
            echo "<td>".$RP["vl_venda"]."</td>";
            echo "</tr>";
          }
        ?>
        </tbody>
    </table>
    </div>

  </main>
  <script src="form-validation.js"></script>

  <script>
  function seleciona(cd_produto)
  {
    window.open('menu.php?modulo=cadastro_orcamento&acao=insere_produto&cd_orcamento=<? echo $cd_orcamento; ?>&cd_produto='+cd_produto,'_self')
  }
  function removendo(cd_produto)
  {
    window.open('menu.php?modulo=cadastro_orcamento&acao=remove_produto&cd_orcamento=<? echo $cd_orcamento; ?>&cd_produto='+cd_produto,'_self')
  }

  </script>