<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Veículos</h1>
        <div class="btn-toolbar mb-0 mb-md-0">
            <button type="button" class="w-100 btn btn-primary" onclick='window.open("menu.php?modulo=cadastro_veiculo&cd_veiculo=0","_self");'>Novo</button>
        </div>
    </div>

    <table id="example" style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Veículo</th>
                <th>Placa</th>
                <th>Cor</th>
                <th>Ano</th>
                <th>Modelo</th>
            </tr>
        </thead>
        <tbody>
        <?php
          include "conecta.php";
          $SQL = "select * from veiculos order by ds_veiculo";
          $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
          while ($RS = mysqli_fetch_array($RSS)) {
              echo "<tr onClick='Clica(".$RS["cd_veiculo"].")'>";
              echo "<td>".$RS["cd_veiculo"]."</td>";
              echo "<td>".$RS["ds_veiculo"]."</td>";
              echo "<td>".$RS["ds_placa"]."</td>";
              echo "<td>".$RS["ds_cor"]."</td>";
              echo "<td>".$RS["ds_ano"]."</td>";
              echo "<td>".$RS["ds_modelo"]."</td>";
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

  function Clica(cd_veiculo) {
    window.open('menu.php?modulo=cadastro_veiculo&cd_veiculo=' + cd_veiculo, "_self");
  }
</script>
