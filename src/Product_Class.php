<?php
class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity = 1) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getTotalPrice() {
        return $this->price * $this->quantity;
    }
}

