<?php
ob_end_clean();

class UsePDO
{
  private $servername = "localhost";
  private $dbname = "ecommerce_unipar";
  private $username = "root";
  private $password = "";

  function getInstance()
  {
    if (empty($instance)) {
      $instance = $this->connection();
    }
    return $instance;
  }

  private function connection()
  {
    try {
      $conn = new PDO(
        "mysql:host=$this->servername;
        dbname=$this->dbname",
        $this->username,
        $this->password
      );

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage() . "<br>";
      exit();
    }
  }

  private function createTable()
  {
    try {
      $conn = $this->getInstance();
      $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				nome VARCHAR(50) NOT NULL,
				email VARCHAR(50) NOT NULL,
				senha VARCHAR(255) NOT NULL
			)";

      $sql_fabricantes = "CREATE TABLE IF NOT EXISTS fabricantes (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
				nome VARCHAR(50) NOT NULL
			)";

      $sql_produtos = "CREATE TABLE IF NOT EXISTS produtos (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        nome VARCHAR(100) NOT NULL,
        preco FLOAT(12) NOT NULL,
        urlImagem VARCHAR(1000) NOT NULL,
        idFabricante INT(6) UNSIGNED NOT NULL,
        CONSTRAINT FK_FabricanteProduto FOREIGN KEY (idFabricante)
        REFERENCES fabricantes(id)
      )";

      $conn->exec($sql_usuarios);
      $conn->exec($sql_fabricantes);
      $conn->exec($sql_produtos);
    } catch (PDOException $e) {
      echo "Erro ao criar tabela" . "<br>" . $e->getMessage();
    }
  }

  public function createTables()
  {
    $this->createTable();
  }

  public function insert($sql)
  {
    try {
      $conn = $this->getInstance();
      $this->createTable();
      $conn->exec($sql);
      return 'Cadastro realizado com sucesso!';
    } catch (PDOException $e) {
      return "Erro ao inserir os dados" . "<br>" . $e->getMessage();
    }
  }

  public function select($sql)
  {
    try {
      $conn = $this->getInstance();
      $this->createTable();
      $result = $conn->query($sql);

      return $result;
    } catch (PDOException $e) {
      echo "Erro ao buscar os dados" . "<br>" . $e->getMessage();
    }
  }

  public function update($sql)
  {
    try {
      $conn = $this->getInstance();
      $this->createTable();
      $conn->query($sql);

      return 'Cadastro atualizado com sucesso!';
      exit;
    } catch (PDOException $e) {
      echo "Erro ao atualizar os dados" . "<br>" . $e->getMessage();
    }
  }

  public function delete($sql)
  {
    try {
      $conn = $this->getInstance();
      $this->createTable();
      $conn->query($sql);

      return 'Cadastro excluído com sucesso!';
    } catch (PDOException $e) {
      echo "Erro ao excluir os dados" . "<br>" . $e->getMessage();
    }
  }
}
