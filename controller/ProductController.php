<?php
use Model\DBConnection;
use Model\ProductDB;
use Model\Product;


class ProductController
{
    public ProductDB $productDB;

    public function __construct()
    {
        $connection = new DBConnection("mysql:host=localhost;dbname=manage", "root", "Cubi@2712");
        $this->productDB = new ProductDB($connection->connect());
    }


    public function showList()
    {
        $products = $this->productDB->getAll();
        include_once "views/list.php";
    }

    public function edit()
    {
        $id = $_REQUEST['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $product = $this->productDB->getID($id);
            include 'views/edit.php';
        } else {

            $errors = [];
            $fields = ['name', 'species', 'price', 'quantity', 'description'];

            foreach ($fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = 'Please';
                }
            }
            if (empty($errors)) {
                $product = new Product($_POST['name'], $_POST['species'], $_POST['price'], $_POST['quantity'], $_POST['description']);
                $product->setId($id);
                $this->productDB->update($id, $product);
                header('Location: index.php');
            } else {
                $product = $this->productDB->getID($id);
                include 'views/edit.php';
            }
        }
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include 'views/add.php';
        } else {
            $errors = [];
            $fields = ['name', 'species', 'price', 'quantity', 'description'];

            foreach ($fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = 'Please';
                }
            }

            if (empty($errors)) {
                $product = new Product($_POST['name'], $_POST['species'], $_POST['price'], $_POST['quantity'], $_POST['description']);
                $this->productDB->create($product);
                header('Location: index.php');
            } else {
                include 'views/add.php';
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->productDB->delete($id);
        header('Location: index.php');
    }

    public function search()
    {
        $pro = $this->productDB->search();
        include 'views/search.php';
    }
}