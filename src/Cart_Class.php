<?php
class Cart {
    private $items = [];

    public function addProduct(Product $product) {
        foreach ($this->items as $item) {
            if ($item->getName() == $product->getName()) {
                $item->setQuantity($item->getQuantity() + $product->getQuantity());
                return;
            }
        }
        $this->items[] = $product;
    }

    public function removeProduct($productName) {
        foreach ($this->items as $key => $item) {
            if ($item->getName() == $productName) {
                unset($this->items[$key]);
                return;
            }
        }
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotalPrice();
        }
        return $total;
    }

    public function displayCart() {
        if (empty($this->items)) {
            echo "<p>Your cart is empty.</p>";
            return;
        }
        echo "<ul>";
        foreach ($this->items as $item) {
            echo "<li>" . $item->getName() . " - $" . $item->getPrice() . " x " . $item->getQuantity() . " = $" . $item->getTotalPrice() . "</li>";
        }
        echo "</ul>";
        echo "<p>Total: $" . $this->getTotalPrice() . "</p>";
    }

    public function getItems() {
        return $this->items;
    } 
}
