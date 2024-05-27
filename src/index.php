<?php
session_start();
require_once "config.php";
require "Product_Class.php";
require "Cart_Class.php";

try {
    $cart = isset($_SESSION['cart']) ? unserialize($_SESSION['cart']) : new Cart();
} catch (Exception $e) {
    // Handle unserialization error
    echo 'Unserialization Error: ' . $e->getMessage();
}

$products = [
    new Product("Product 1", 10.99),
    new Product("Product 2", 12.99),
    new Product("Product 3", 8.99),
    new Product("Product 4", 39.99),
    new Product("Product 5", 99.99),
    new Product("Product 6", 69.99),
    new Product("Product 7", 109.99),
    new Product("Product 8", 34.99),
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productIndex = intval($_POST['product_index']);
    if (isset($products[$productIndex])) {
        $cart->addProduct($products[$productIndex]);
        try {
            $_SESSION['cart'] = serialize($cart);
        } catch (Exception $e) {
            // Handle serialization error
            echo 'Serialization Error: ' . $e->getMessage();
        }
    }
}

function getImagePath($db) {
    global $db;
    $query = "SELECT image_path FROM images ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($db, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['image_path'];
    } else {
        return null;
    }
}
$imagePath = GetImagePath($db);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!--<script type = "text/javascript" src="js/scripts.js"></script>-->
        <script>
        function redirectToLogin() {
            window.location.href = "login.php";
        }

        function redirectToSignUp() {
            window.location.href = "register.php";
        }
        
        function redirectToUploadPage() {
            window.location.href = "upload.php"
        }
        function showMp3Audio() {
            var audioContainer = document.getElementById('audio-player');
            audioContainer.style.display = 'block';
            audioContainer.innerHTML = '<audio controls><source src="assets/stone.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio>';
        }
        function showMp4Video() {
            var mp4Container = document.getElementById('mp4-player');
            mp4Container.style.display = 'block';
            mp4Container.innerHTML = '<video width="560" height="315" controls><source src="assets/monkey.mp4" type="video/mp4">Your browser does not support the video tag.</video>';
        }
        function showMap() {
            var mapContainer = document.getElementById('map-container');
            mapContainer.style.display = 'block';
            mapContainer.innerHTML = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5270.1051205358435!2d27.571932783334525!3d47.1722407990639!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb61af5ef507%3A0x95f1e37c73c23e74!2sAlexandru%20Ioan%20Cuza%20University!5e0!3m2!1sen!2sro!4v1716237805586!5m2!1sen!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        }
        function showVideo() {
            var videoContainer = document.getElementById('youtube-embed');
            videoContainer.style.display = 'block';
            videoContainer.innerHTML = '<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ?si=1c4X8f0rczve4Rl1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
        }
        function showSVG() {
            var svgContainer = document.getElementById('svg-container');
            svgContainer.style.display = 'block';
        }

        function showCanvas() {
            var canvasContainer = document.getElementById('canvas-container');
            canvasContainer.style.display = 'block';

            var canvas = document.getElementById('myCanvas');
            var context = canvas.getContext('2d');
            context.fillStyle = '#FF0000';
            context.fillRect(10, 10, 150, 75);
        }

        /*function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart-count').textContent = cart.length;
        }

        function addToCart(productName, productPrice) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push({ name: productName, price: productPrice });
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
        }*/

        function redirectToCartPage() {
            window.location.href = 'cart.php';
        }

    </script>
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v20.0" nonce="YtioHcGC"></script>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
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
                    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <div class="d-flex">
                        <p class="me-3 my-auto"><?php echo $_SESSION['name']; ?></p>
                        <?php if($_SESSION['is_admin'] == 1): ?>
                            <a href="admin.php" class="btn btn-outline-dark me-2">Admin Panel</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-outline-dark me-2">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="d-flex login-signup">
                        <a href="login.php" class="btn btn-outline-dark me-2">Login</a>
                        <a href="register.php" class="btn btn-outline-dark">Sign Up</a>
                    </div>
                <?php endif; ?>
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
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="corner-image">
                        <?php if ($imagePath): ?>
                            <img src="<?php echo $imagePath; ?>" alt="Database Image" width="100" height="100"/>
                        <?php endif; ?>
                    </div>
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
                    <button onclick="redirectToUploadPage()" class="btn btn-outline-light mt-3">Upload Image</button>
                    <button onclick="showMap()" class="btn btn-outline-light mt-3">Show Map</button>
                    <button onclick="showVideo()" class="btn btn-outline-light mt-3">Show YouTube Video</button>
                    <button onclick="showMp3Audio()" class="btn btn-outline-light mt-3">Play MP3</button>
                    <button onclick="showMp4Video()" class="btn btn-outline-light mt-3">Play MP4</button>
                    <br>
                    <button onclick="showSVG()" class="btn btn-outline-light mt-3">Show SVG</button>
                    <button onclick="showCanvas()" class="btn btn-outline-light mt-3">Show Canvas</button>
                    <div id="map-container" style="display:none; margin-top: 20px;"></div>
                    <div id="youtube-embed" style="display:none; margin-top: 20px;"></div>
                    <div id="audio-player" style="display:none; margin-top: 20px;"></div>
                    <div id="mp4-player" style="display:none; margin-top: 20px;"></div>
                    <div id="svg-container" style="display:none; margin-top: 20px;">
                        <svg width="100" height="100">
                            <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
                        </svg>
                    </div>
                    <div id="canvas-container" style="display:none; margin-top: 20px;">
                        <canvas id="myCanvas" width="200" height="100" style="border:1px solid #000000;"></canvas>
                    </div>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($products as $index => $product) : ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="<?php echo $product->getName(); ?>" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $product->getName(); ?></h5>
                                    <!-- Product price-->
                                    $<?php echo number_format($product->getPrice(), 2); ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <form method="post">
                                        <input type="hidden" name="product_index" value="<?php echo $index; ?>">
                                        <button class="btn btn-outline-dark mt-auto" type="submit" name="add_to_cart">Add to Cart</button>
                                    </form>
                                    <br>
                                    <div class="fb-like" data-href="http://localhost:8080" data-width="10" data-layout="" data-action="" data-size="" data-share="false"></div>
                                    <div class="fb-share-button" data-href="http://localhost:8080" data-layout="" data-size=""><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%3A8080%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                                    <!--<iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Flocalhost%3A8080&width=450&layout&action&size&share=true&height=35&appId" width="450" height="35" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>-->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
                <br>
                <!--<div style="text-align:center;">
                    <span>
                    <style>
                        #map {
                            display: none;
                            width: 600px;
                            height: 450px;
                        }
                        #video {
                            display: none;
                            width: 560px;
                            height: 315px;
                        }
                     </style>
                        <button onclick="showMap()">Afișează Harta</button>
                        <div id="map-container"></div>
                        <br>
                        <button onclick="showVideo()">Youtube</button>
                        <div id="youtube-embed"></div>
                    </span>
                </div>-->
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>