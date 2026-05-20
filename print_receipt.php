<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

// Fetch the latest order placed by the user
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1") or die('query failed');
$order = mysqli_fetch_assoc($order_query);

if (!$order) {
    die('No order found');
}

// Fetch ordered products
$order_id = $order['id'];
$products_query = mysqli_query($conn, "SELECT * FROM `order_items` WHERE order_id = '$order_id'") or die('query failed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        #receipt {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<button onclick="printReceipt()">Print Receipt</button>

<div id="receipt" style="display: block;"> <!-- Show the receipt by default for printing -->
    <h1>Order Receipt</h1>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['number']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['method']); ?></p>
    <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($order['total_price']); ?>/-</p>
    <h2>Items Ordered:</h2>
    <ul>
        <?php
        if (mysqli_num_rows($products_query) > 0) {
            while ($product = mysqli_fetch_assoc($products_query)) {
                echo '<li>' . htmlspecialchars($product['product_name']) . ' (Qty: ' . htmlspecialchars($product['quantity']) . ') - ₹' . htmlspecialchars($product['price']) . '/-</li>';
            }
        } else {
            echo '<li>No products found in this order.</li>';
        }
        ?>
    </ul>
    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['placed_on']); ?></p>
</div>

<script>
function printReceipt() {
    var printContents = document.getElementById('receipt').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents; // Restore original content after printing
}
</script>

</body>
</html>
