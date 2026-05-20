<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $user_id = $_SESSION['user_id'];

    // Fetch order details
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id' AND user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($order_query) > 0) {
        $order_details = mysqli_fetch_assoc($order_query);

        // Fetch order items
        $items_query = mysqli_query($conn, "SELECT oi.*, p.name AS product_name FROM `order_items` oi JOIN `products` p ON oi.product_id = p.id WHERE oi.order_id = '$order_id'") or die('query failed');
        
        // Check if items query returned results
        if (mysqli_num_rows($items_query) > 0) {
            $items = mysqli_fetch_all($items_query, MYSQLI_ASSOC);
        } else {
            $items = []; // No items found
        }
    } else {
        echo "Order not found!";
        exit;
    }
} else {
    header('location:orders.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .receipt {
            border: 1px solid #000;
            padding: 20px;
            width: 80%;
            margin: auto;
        }
        .receipt h2 {
            text-align: center;
        }
        .receipt p {
            margin: 5px 0;
        }
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
            .print-button {
                display: none; /* Hide the button when printing */
            }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</head>
<body>

<div class="receipt">
    <h2>Order Receipt</h2>
    <p><strong>Placed on:</strong> <?php echo htmlspecialchars($order_details['placed_on']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($order_details['name']); ?></p>
    <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($order_details['number']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($order_details['email']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($order_details['address']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order_details['method']); ?></p>
    <p>Your Orders: <span><?php echo htmlspecialchars($order_details['total_products']); ?></span></p>

    <!-- <h3>Items Ordered:</h3>
    <ul>
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <li><?php echo htmlspecialchars($item['quantity']) . ' x ' . htmlspecialchars($item['product_name']) . ' @ ₹' . htmlspecialchars($item['price']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No items found for this order.</li>
        <?php endif; ?>
    </ul> -->

    <p><strong>Total Price:</strong> ₹<?php echo htmlspecialchars($order_details['total_price']); ?>/-</p>
    <p><strong>Delivery Status:</strong> 
        <span style="color:<?php echo ($order_details['payment_status'] == 'pending') ? 'tomato' : 'green'; ?>">
            <?php echo htmlspecialchars($order_details['payment_status']); ?>
        </span>
    </p>
</div>

<button class="print-button" onclick="printReceipt()">Print Receipt</button>

</body>
</html>
