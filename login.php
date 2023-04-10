<?php
require_once "Usuario.php";
session_start();

$usuario = new Usuario();

if (isset($_POST['email'], $_POST['senha'])) {
  $result = $usuario->findByEmail($_POST);
  $errorMessage = "Erro: Usuário e/ou senha incorretos!";

  if (empty($result)) {
    echo $errorMessage;
    exit;
  }

  $password = $_POST['senha'];
  $passwordDb = $result[0]['senha'];


  if (password_verify($password, $passwordDb)) {
    $_SESSION['usuario'] = $result[0]['nome'];

    echo "success";
  } else {
    echo $errorMessage;
  }
}
