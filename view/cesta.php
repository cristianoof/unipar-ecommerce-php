<?php
include('../verificar-sessao.php');

$titlePage = "Cesta";

require_once "header.php";
?>

<main class="main-container">
  <div class="column-flex" style="flex: 1;">
    <div class="main-header">
      <h3>Produtos adicionados na Cesta</h3>
      <button type="button" class="btn btn-primary" onclick="clearProductBasket()">
        <i class="ph ph-basket"></i>
        limpar cesta
      </button>
    </div>

    <table class="table-data">
      <thead>
        <tr>
          <th>Id</th>
          <th></th>
          <th>Nome</th>
          <th>Preço</th>
          <th>Fabricante</th>
          <th class="action-button-column" style="width: 140px;"></th>
        </tr>
      </thead>
      <tbody id="tbodyProductBasket"></tbody>
    </table>
  </div>
</main>

<?php
require_once "footer.php";
?>