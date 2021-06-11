<?php


namespace Model;

class Product{
    public string $name;
    public string $species;
    public int $price;
    public int $quantity;
    public string $description;
    public int $id;

    public function __construct(string $name,string $species,int $price,int $quantity,string $description){
        $this->name = $name;
        $this->species = $species;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
    }
    public function setId($id){
        $this->id = $id;
    }
}