<?php
include('../verificar-sessao.php');

$titlePage = "Fabricantes";

require_once 'header.php';
?>

<main class="main-container">
  <div class="column-flex" style="flex: 1;">
    <div class="main-header">
      <h3>Lista de Fabricantes</h3>
    </div>

    <table class="table-data">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nome</th>
          <th class="action-button-column"></th>
          <th class="action-button-column"></th>
        </tr>
      </thead>
      <tbody id="tbodyManufacturers">
      </tbody>
    </table>
  </div>

  <div class="column-flex" style="flex: 0.3;">
    <div class="main-header">
      <h3>Cadastro de Fabricantes</h3>
    </div>

    <form id="formManufacturers" class="form-register">
      <div class="input-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" />
      </div>

      <div class="row-flex" style="flex-wrap: wrap-reverse;">
        <button type="button" class="btn btn-secondary btn-full-width" onclick="cancelRegister('formManufacturers')">Cancelar</button>
        <button type="button" id="buttonCreate" class="btn btn-primary btn-full-width" onclick="createRegister(event, 'formManufacturers', 'cadastro-fabricante')">Cadastrar</button>
        <button type="button" id="buttonSave" class="btn btn-primary btn-full-width" style="display: none;">Salvar</button>
      </div>
    </form>
  </div>
</main>

<?php
require_once 'footer.php'
?>