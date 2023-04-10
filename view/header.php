<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="../css/global.css" />
  <link rel="stylesheet" type="text/css" href="../css/header.css" />
  <link rel="stylesheet" type="text/css" href="../css/footer.css" />

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

  <script src="https://unpkg.com/@phosphor-icons/web"></script>

  <title>Uni.Store | <?php echo $titlePage ?></title>
</head>

<body>
  <header class="header-container">
    <div class="header-logo">
      <img src="../assets/images/logo-negative.svg" alt="logo empresa" />
    </div>

    <div class="header-actions">
      <nav class="header-menu-items">
        <a class="header-menu-item" href="produtos.php">
          <i class="ph ph-package"></i>
          <span>Produtos</span>
        </a>
        <a class="header-menu-item" href="fabricantes.php">
          <i class="ph ph-factory"></i>
          <span>Fabricantes</span>
        </a>
        <a class="header-menu-item" href="#">
          <i class="ph ph-user-circle"></i>
          <span><?php echo $_SESSION['usuario'] ?></span>
        </a>
        <a class="header-menu-item" href="#" onclick="logout()">
          <i class="ph ph-sign-out"></i>
          <span>Sair</span>
        </a>
      </nav>

      <a class="header-basket" href="cesta.php">
        <i class="ph ph-basket"></i>
        <span>Cesta</span>
        <span class="basket-quantity"></span>
      </a>
    </div>
  </header>