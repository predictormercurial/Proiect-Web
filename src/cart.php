<?php
session_start();
require_once "config.php";
require "Product_Class.php";
require "Cart_Class.php";

$cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clear'])) {
        $cart = new Cart();
    } elseif (isset($_POST['remove'])) {
        $productName = $_POST['product'];
        $cart->removeProduct($productName);
    }
    $_SESSION['cart'] = serialize($cart);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cart - Your Website</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <!--<script>
        var storedCart = JSON.parse(localStorage.getItem("cart")) || [];
        for (var i = 0; i < storedCart.length; i++) {
            var product = storedCart[i];
            var productName = product.name;
            var productPrice = product.price;
            var form = document.createElement("form");
            form.method = "post";
            form.innerHTML = `<input type="hidden" name="product" value="${productName}"><button class="btn btn-danger" name="remove">Remove</button>`;
            document.getElementById("cart-items").appendChild(form);
        }
    </script>-->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Start Bootstrap</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="button" onclick="redirectToCartPage()">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count"><?php echo count($cart->getItems()); ?></span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Your Cart</h1>
                <p class="lead fw-normal text-white-50 mb-0">Review your selected items</p>
            </div>
        </div>
    </header>

    <!-- Cart Items Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h2>Your Cart Items</h2>
            <?php $cart->displayCart(); ?>
            <form method="post">
                <button class="btn btn-danger mt-3" name="clear">Clear Cart</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2024</p></div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function redirectToCartPage() {
            window.location.href = 'cart.php';
        }
    </script>
</body>
</html>