<?php
require_once 'PDO.php';

class Fabricante
{
  private $pdo;

  function __construct()
  {
    $this->pdo = new UsePDO();
  }

  public function findAll()
  {
    $sql = "SELECT * FROM fabricantes";
    $result = $this->pdo->select($sql);

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create($formData)
  {
    $nome = $formData['nome'];

    $sql = "INSERT INTO fabricantes (nome) VALUES ('$nome')";
    return $this->pdo->insert($sql);
  }

  public function update($formData)
  {
    $id = $formData['id'];
    $nome = $formData['nome'];

    $sql = "UPDATE fabricantes SET nome = '$nome' WHERE id = '$id'";
    return $this->pdo->update($sql);
  }

  public function delete($formData)
  {
    $id = $formData['id'];

    $sql = "DELETE FROM fabricantes WHERE id = '$id'";
    return $this->pdo->delete($sql);
  }
}
