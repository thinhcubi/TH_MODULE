<?php
namespace Model;

use Model\DBConnection;
use Model\Product;

class ProductDB
{
    public $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAll() : array
    {
        $sql = "SELECT * FROM `manage_2`";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $products = [];
        foreach ($result as $item) {
            $product = new Product($item['name'],$item['species'],$item['price'],$item['quantity'],$item['description']);
            $product->id = $item['id'];
            $products[] = $product;
        }
        return $products;
    }
    public function getID($id): array
    {
        $sql = 'SELECT * FROM `manage_2` WHERE id=?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $products = [];
        foreach ($result as $item){
            $product = new Product($item['name'],$item['species'],$item['price'],$item['quantity'],$item['description']);
            $product->setId($item['id']);
            $products[] = $product ;
        }
        return $products;
    }
    public function update($id,$product)
    {
        $sql = 'UPDATE `manage_2` SET name = ?,species = ?, price = ? ,quantity = ?,description = ? WHERE id=?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(1,$product->name);
        $stmt->bindParam(2,$product->species);
        $stmt->bindParam(3,$product->price);
        $stmt->bindParam(4,$product->quantity);
        $stmt->bindParam(5,$product->description);
        $stmt->bindParam(6,$id);
        $stmt->execute();
    }
    public function create(object $product)
    {
        $sql = "INSERT INTO manage_2(name,species,price,quantity,description) VALUES(?,?,?,?,?) ";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1,$product->name);
        $statement->bindParam(2,$product->species);
        $statement->bindParam(3,$product->price);
        $statement->bindParam(4,$product->quantity);
        $statement->bindParam(5,$product->description);
        return $statement->execute();
    }
    public function delete($id)
    {
        $sql = "DELETE FROM manage_2 WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1,$id);
        return $statement->execute();
    }
    public function search() : array
    {
        $value = $_POST['search'];
        $sql  = "SELECT * FROM `manage_2` WHERE `name` LIKE "."'%".$value."%"."'; ";
        $stmt = $this->connection->query($sql);
        $result = $stmt->fetchAll();
        $pro= [];

        foreach ($result as $item){
            $product = new Product($item['name'],$item['species'],$item['price'],$item['quantity'],$item['description']);
            $product->setId($item['id']);
            $pro[]= $product;
        }
        return $pro;
    }

}