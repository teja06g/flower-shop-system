<?php

@include 'config.php';

session_start();

$deliveryboy_id = $_SESSION['deliveryboy_id'];

if(!isset($deliveryboy_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>DeliveryBoy Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'delivery_header.php'; ?>

<section class="dashboard">

   <h1 class="title">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['total_price'];
            };
         ?>
         <h3>₹<?php echo $total_pendings; ?>/-</h3>
         <p>Total Pending Payments Ammount</p>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
               $total_completes += $fetch_completes['total_price'];
            };
         ?>
         <h3>₹<?php echo $total_completes; ?>/-</h3>
         <p>Total Completed Payments Ammount</p>
      </div>

      <div class="box">
         <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Orders Placed</p>
      </div>

    

   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>