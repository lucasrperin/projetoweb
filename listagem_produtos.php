<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Produtos</h1>
      </div>
    <table id="example"  style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Produto</th>
				        <th>Valor</th>
                <th>Unidade</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
        <?php
          include "conecta.php";
          $SQL = "select * from produtos  order by ds_produto";
          $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RS = mysqli_fetch_array($RSS))
          {
            echo "<tr onClick='Clica(".$RS["cd_produto"].")' >";
            echo "<td>".$RS["cd_produto"]."</td>";
            echo "<td>".$RS["ds_produto"]."</td>";
			      echo "<td>R$".$RS["vl_venda"]."</td>";
            echo "<td>".$RS["ds_unidade"]."</td>";
            echo "<td>".$RS["vl_estoque"]."</td>";
            echo "</tr>";
          }
        ?>
        </tbody>
    </table>

  </main>

<script>
  $(document).ready(function () {
    $('#example').DataTable();
  });


function Clica(cd_produto)
{
	window.open('menu.php?modulo=cadastro_produto&cd_produto='+cd_produto, "_self");
}  
</script>
