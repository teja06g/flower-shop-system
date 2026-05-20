<?php
@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// ✅ CANCEL ORDER LOGIC
if(isset($_GET['cancel'])){
   $delete_id = $_GET['cancel'];

   mysqli_query($conn, "DELETE FROM `orders` WHERE id='$delete_id'") or die('query failed');

   header('location:orders.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Your Orders</h3>
</section>

<section class="placed-orders">
    <h1 class="title">Placed Orders</h1>

    <div class="box-container">
        <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
        ?>
                <div class="box">
                    <p>Placed on: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                    <p>Name: <span><?php echo $fetch_orders['name']; ?></span></p>
                    <p>Mobile Number: <span><?php echo $fetch_orders['number']; ?></span></p>
                    <p>Email: <span><?php echo $fetch_orders['email']; ?></span></p>
                    <p>Address: <span><?php echo $fetch_orders['address']; ?></span></p>
                    <p>Payment Method: <span><?php echo $fetch_orders['method']; ?></span></p>
                    <p>Your Orders: <span><?php echo $fetch_orders['total_products']; ?></span></p>
                    <p>Total Price: <span>Rs <?php echo $fetch_orders['total_price']; ?>/-</span></p>
                    <p>Delivery Status: 
                        <span style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'tomato' : 'green'; ?>">
                            <?php echo $fetch_orders['payment_status']; ?>
                        </span>
                    </p>

                    <!-- PRINT BUTTON -->
                    <a href="generate_receipt.php?order_id=<?php echo $fetch_orders['id']; ?>" class="btn" target="_blank">
                        Print Receipt
                    </a>

                    <!-- CANCEL BUTTON -->
                    <?php if($fetch_orders['payment_status'] == 'pending'){ ?>
                        <a href="orders.php?cancel=<?php echo $fetch_orders['id']; ?>" 
                           class="btn" 
                           style="background:red;"
                           onclick="return confirm('Are you sure you want to cancel this order?');">
                           Cancel Order
                        </a>
                    <?php } ?>

                </div>
        <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
        ?>
    </div>
</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>