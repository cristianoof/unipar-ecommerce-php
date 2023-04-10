<?php
require_once "Produto.php";

$produto = new Produto();
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") echo json_encode($produto->findAll());
if ($method === "POST") {
  if ($_POST['action'] === 'create') echo $produto->create($_POST);
  if ($_POST['action'] === 'update') echo $produto->update($_POST);
  if ($_POST['action'] === 'delete') echo $produto->delete($_POST);
}
