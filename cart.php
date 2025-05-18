<?php
session_start();

if (isset($_POST['add'])) {
    $item = [
        "id" => $_POST['id'],
        "name" => $_POST['name'],
        "price" => $_POST['price']
    ];
    $_SESSION['cart'][] = $item;
    header("Location: cart.php");
    exit;
}

if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

$showSummary = isset($_GET['checkout']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart - BuyNest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="pt-4 bg-light">
<div class="container">
    <h2 class="mb-4">Your Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (PKR)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $index => $item):
                    $total += $item['price'];
                ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= number_format($item['price']) ?></td>
                    <td><a href="?remove=<?= $index ?>" class="btn btn-danger btn-sm">Remove</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Total: PKR <?= number_format($total) ?></h4>
            <div>
                <a href="?checkout=true" class="btn btn-success">Checkout</a>
                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>

        <?php if ($showSummary): ?>
            <div class="card mt-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $item['name'] ?>
                                <span>PKR <?= number_format($item['price']) ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Total</strong>
                            <strong>PKR <?= number_format($total) ?></strong>
                        </li>
                    </ul>
                    <p class="mt-3 text-success">Thank you for your order!</p>
                </div>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="index.php" class="btn btn-primary">Go Back to Shop</a>
    <?php endif; ?>
</div>
</body>
</html>
