<?php
require_once "Usuario.php";

$usuario = new Usuario();
$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") echo json_encode($usuario->findAll());
if ($method === "POST") {
  if ($_POST['action'] === 'create') echo $usuario->create($_POST);
  if ($_POST['action'] === 'update') echo $usuario->update($_POST);
  if ($_POST['action'] === 'delete') echo $usuario->delete($_POST);
}
