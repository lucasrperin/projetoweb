<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Clientes</h1>
        <div class="btn-toolbar mb-0 mb-md-0">
            <button type="button" class="w-100 btn btn-primary" onclick='window.open("menu.php?modulo=cadastro_cliente&cd_cliente=0","_self");'>Novo</button>
        </div>
      </div>
      
    <table id="example"  style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Cidade/UF</th>
            </tr>
        </thead>
        <tbody>
        <?php
          include "conecta.php";
          $SQL = "select * from clientes order by ds_cliente";
          $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RS = mysqli_fetch_array($RSS))
          {
            echo "<tr onClick='Clica(".$RS["cd_cliente"].")' >";
            echo "<td>".$RS["cd_cliente"]."</td>";
            echo "<td>".$RS["ds_cliente"]."</td>";
            echo "<td>".$RS["ds_email"]."</td>";
            echo "<td>".$RS["ds_celular"]."</td>";
            echo "<td>".$RS["ds_cidade_cliente"]."/".$RS["ds_uf_cliente"]."</td>";
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


function Clica(cd_cliente)
{
	window.open('menu.php?modulo=cadastro_cliente&cd_cliente='+cd_cliente, "_self"); 
}  
</script>
