<?php
include('../verificar-sessao.php');

$titlePage = "Produtos";

require_once "header.php";
?>

<main class="main-container">
  <div class="column-flex" style="flex: 1;">
    <div class="main-header">
      <h3>Lista de Produtos</h3>
      <button type="button" class="btn btn-primary" onclick="handleAddProductToBasket()">
        <i class="ph ph-basket"></i>
        adicionar a cesta
      </button>
    </div>

    <table class="table-data">
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th></th>
          <th>Nome</th>
          <th>Preço</th>
          <th>Fabricante</th>
          <th class="action-button-column"></th>
          <th class="action-button-column"></th>
        </tr>
      </thead>
      <tbody id="tbodyProducts"></tbody>
    </table>
  </div>

  <div class="column-flex" style="flex: 0.3;">
    <div class="main-header">
      <h3>Cadastro de Produtos</h3>
    </div>

    <form id="formProduct" class="form-register">
      <div class="input-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome">
      </div>
      <div class="input-group">
        <label for="preco">Preço</label>
        <input type="text" id="preco" name="preco">
      </div>
      <div class="input-group">
        <label for="idFabricante">Fabricante</label>
        <select name="idFabricante" id="selectManufacturers">
          <option value="">Selecione</option>
        </select>
      </div>
      <div class="input-group">
        <label for="urlImagem">URL da imagem</label>
        <input type="text" id="urlImagem" name="urlImagem">
      </div>

      <div class="row-flex" style="flex-wrap: wrap-reverse;">
        <button type="button" class="btn btn-secondary btn-full-width" onclick="cancelRegister('formProduct')">Cancelar</button>
        <button type="button" id="buttonCreate" class="btn btn-primary btn-full-width" onclick="createRegister(event, 'formProduct', 'cadastro-produto')">Cadastrar</button>
        <button type="button" id="buttonSave" class="btn btn-primary btn-full-width" style="display: none;">Salvar</button>
      </div>
    </form>
  </div>
</main>

<?php
require_once "footer.php";
?>