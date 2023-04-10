<?php
require_once 'PDO.php';

class Produto
{
  private $pdo;

  function __construct()
  {
    $this->pdo = new UsePDO();
  }

  public function findAll()
  {
    $sql = "SELECT produtos.*, fabricantes.nome AS nomeFabricante 
            FROM produtos JOIN fabricantes ON produtos.idFabricante = fabricantes.id";
    $result = $this->pdo->select($sql);

    return $result->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create($formData)
  {
    $nome = $formData['nome'];
    $preco = $formData['preco'];
    $urlImagem = $formData['urlImagem'];
    $idFabricante = $formData['idFabricante'];

    $sql = "INSERT INTO produtos (nome, preco, urlImagem, idFabricante) 
            VALUES ('$nome', $preco, '$urlImagem', '$idFabricante')";
    return $this->pdo->insert($sql);
  }

  public function update($formData)
  {
    $id = $formData['id'];
    $nome = $formData['nome'];
    $preco = $formData['preco'];
    $urlImagem = $formData['urlImagem'];
    $idFabricante = $formData['idFabricante'];

    $sql = "UPDATE produtos 
            SET nome = '$nome', preco = $preco, urlImagem = '$urlImagem', idFabricante = '$idFabricante'
            WHERE id = '$id'";
    return $this->pdo->update($sql);
  }

  public function delete($formData)
  {
    $id = $formData['id'];

    $sql = "DELETE FROM produtos WHERE id = '$id'";
    return $this->pdo->delete($sql);
  }
}
