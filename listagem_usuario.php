<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuarios</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div>

    <table id="example"  style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
            </tr>
        </thead>
        <tbody>
        <?php
          include "conecta.php";
          $SQL = "select * from usuarios  order by ds_usuario";
          $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RS = mysqli_fetch_array($RSS))
          {
            echo "<tr onClick='Clica(".$RS["cd_usuario"].")' >";
            echo "<td>".$RS["cd_usuario"]."</td>";
            echo "<td>".$RS["ds_usuario"]."</td>";
            echo "<td>".$RS["ds_email"]."</td>";
            echo "<td>".$RS["ds_senha"]."</td>";
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


function Clica(cd_usuario)
{
	window.open('menu.php?modulo=cadastro_usuario&cd_usuario='+cd_usuario, "_self");
}  
</script>
