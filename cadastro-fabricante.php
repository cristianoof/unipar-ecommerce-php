<?php
require_once "Fabricante.php";

$fabricante = new Fabricante();
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") echo json_encode($fabricante->findAll());
if ($method === "POST") {
  if ($_POST['action'] === 'create') echo $fabricante->create($_POST);
  if ($_POST['action'] === 'update') echo $fabricante->update($_POST);
  if ($_POST['action'] === 'delete') echo $fabricante->delete($_POST);
}
