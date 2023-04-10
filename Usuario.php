<?php
require_once 'PDO.php';

class Usuario
{
  private $pdo;

  function __construct()
  {
    $this->pdo = new UsePDO();
  }

  public function findAll()
  {
    $sql = "SELECT * FROM usuarios";
    $result = $this->pdo->select($sql);

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findByEmail($formData)
  {
    $email = $formData['email'];

    $sql = "SELECT * FROM usuarios
            WHERE email = '$email'";
    $result = $this->pdo->select($sql);

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create($formData)
  {
    $nome = $formData['nome'];
    $email = $formData['email'];
    $senha = $formData['senha'];
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) 
            VALUES ('$nome', '$email', '$hash')";
    return $this->pdo->insert($sql);
  }

  public function update($formData)
  {
    $id = $formData['id'];
    $nome = $formData['nome'];
    $email = $formData['email'];
    $senha = $formData['senha'];

    $sql = "UPDATE usuarios 
            SET nome = '$nome', email = '$email', senha = '$senha'
            WHERE id = '$id'";
    return $this->pdo->update($sql);
  }

  public function delete($formData)
  {
    $id = $formData['id'];

    $sql = "DELETE FROM usuarios WHERE id = '$id'";
    return $this->pdo->delete($sql);
  }
}
