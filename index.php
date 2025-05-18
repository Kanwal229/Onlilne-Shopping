<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle AJAX add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_add'])) {
    $item = [
        "id" => $_POST['id'],
        "name" => $_POST['name'],
        "price" => $_POST['price']
    ];
    $_SESSION['cart'][] = $item;
    echo count($_SESSION['cart']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BuyNest Shopping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light pt-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <h2 class="mb-0">BuyNest Shopping</h2>
            </div>
            <div>
                <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                <a href="signup.php" class="btn btn-outline-success me-3">Sign Up</a>
                <a href="cart.php" class="btn btn-warning">Cart (<span id="cart-count"><?= count($_SESSION['cart']) ?></span>)</a>
            </div>
        </div>

        <div class="row">
            <?php
            $products = [
                ["id" => 1, "name" => "Women Bag", "price" => 3200, "img" => "women-bag.jpg"],
                ["id" => 2, "name" => "Tumbler", "price" => 1500, "img" => "tumbler.jpg"],
                ["id" => 3, "name" => "Women Watch", "price" => 7500, "img" => "women-watch.jpg"],
                ["id" => 4, "name" => "Uroosa Perfume", "price" => 3400, "img" => "uroosa.jpg"],
                ["id" => 5, "name" => "Mens Watch", "price" => 11500, "img" => "mens-watch.jpg"],
                ["id" => 6, "name" => "Wallet", "price" => 3000, "img" => "wallet.jpg"],
                ["id" => 7, "name" => "Mobile Cover", "price" => 1200, "img" => "mobile-cover.jpg"],
                ["id" => 8, "name" => "Sunblock", "price" => 1500, "img" => "sunblock.jpg"],
                ["id" => 9, "name" => "Ring", "price" => 2200, "img" => "ring.jpg"],
                ["id" => 10, "name" => "Glasses", "price" => 4500, "img" => "glasses Picture.jpg"],
                ["id" => 11, "name" => "Body Spray", "price" => 1200, "img" => "body-spray.jpg"],
                ["id" => 12, "name" => "Air Pods", "price" => 2800, "img" => "air pods.jpg"],
            ];

            foreach ($products as $product) {
                echo '
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="images/'.$product['img'].'" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">'.$product['name'].'</h5>
                            <p class="card-text">PKR '.$product['price'].'</p>
                            <button class="btn btn-primary add-to-cart"
                                data-id="'.$product['id'].'"
                                data-name="'.$product['name'].'"
                                data-price="'.$product['price'].'">Add to Cart</button>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <script>
    $(".add-to-cart").click(function () {
        const button = $(this);
        $.post("index.php", {
            ajax_add: true,
            id: button.data("id"),
            name: button.data("name"),
            price: button.data("price")
        }, function (cartCount) {
            $("#cart-count").text(cartCount);
        });
    });
    </script>
</body>
</html>
