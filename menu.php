<?php $modulo = $_REQUEST["modulo"]; ?> 

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ComércioEXP</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript" language="javascript" src="js/jquery-3.5.1.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="menu.php?modulo=listagem_cliente">ComércioEXP</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <form action="logout.php" method="post">
                    <button type="submit" class="btn btn-danger">Sair</button> <!-- Adicione uma classe para estilo -->
                </form>
            </div>
        </div>
    </header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">

          <li class="nav-item">
          <a <?php if ($modulo=="listagem_cliente") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_cliente">
              <span data-feather="file" class="align-text-bottom"></span>
              Clientes
            </a>
          </li>
          <li class="nav-item">
            <a <?php if ($modulo=="listagem_produtos") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_produtos">
              <span data-feather="file" class="align-text-bottom"></span>
              Produtos
            </a>
          </li>
          <li class="nav-item">
            <a <?php if ($modulo=="listagem_usuario") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_usuario">
              <span data-feather="users" class="align-text-bottom"></span>
              Usuarios
            </a>
          </li>
          <li class="nav-item">
            <a <?php if ($modulo=="listagem_orcamento") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_orcamento">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Orçamentos
            </a>
          </li>
		  <li class="nav-item">
            <a <?php if ($modulo=="listagem_veiculos") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_veiculos">
              <span data-feather="truck" class="align-text-bottom"></span>
              Veículos
            </a>
          </li>
		  <li class="nav-item">
            <a <?php if ($modulo=="listagem_viagens") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
             href="menu.php?modulo=listagem_viagens">
              <span data-feather="map-pin" class="align-text-bottom"></span>
              Viagens
            </a>
          </li>
      <li class="nav-item">
        <a <?php if ($modulo=="ws") { echo " class='nav-link active' aria-current='page'"; } else { echo " class='nav-link' "; } ?>
          href="menu.php?modulo=ws">
          <span data-feather="map-pin" class="align-text-bottom"></span>
          Web Service
        </a>
      </li>
        </ul>

       
      </div>
    </nav>

    <?php 
      if (strlen($modulo)==0) { $modulo = "listagem_cliente"; }
      include $modulo.".php";
    ?>
   
  </div>
</div>
  </body>
</html>
