<?php
@include 'config.php';
session_start();

// SESSION CHECK (important)
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
   header('location:login.php');
}

// FORM SUBMIT
if(isset($_POST['submit'])){

   $flower = $_POST['flower_type'];
   $qty = $_POST['quantity'];
   $color = $_POST['color'];
   $wrap = $_POST['wrapping'];
   $msg = $_POST['message'];

   mysqli_query($conn, "INSERT INTO custom_orders(flower_type, quantity, color, wrapping, message)
   VALUES('$flower','$qty','$color','$wrap','$msg')") or die('query failed');

   $success = "Your customized order has been placed!";
}
?>

<!DOCTYPE html>
<html>
<head>
   <title>Customize Bouquet</title>

   <style>
      body {
         font-family: Arial;
         background: #f5f5f5;
      }

      .box {
         width: 400px;
         margin: 50px auto;
         padding: 25px;
         background: #fff;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }

      h2 {
         text-align: center;
         color: #e84393;
      }

      label {
         font-weight: bold;
         display: block;
         margin-top: 10px;
      }

      select, input {
         width: 100%;
         padding: 8px;
         margin-top: 5px;
         border-radius: 5px;
         border: 1px solid #ccc;
      }

      .btn {
         margin-top: 15px;
         background: #e84393;
         color: white;
         border: none;
         padding: 10px;
         cursor: pointer;
      }

      .btn:hover {
         background: #d6307a;
      }

      .back-btn {
         display: inline-block;
         margin-bottom: 10px;
         color: #e84393;
         cursor: pointer;
         text-decoration: none;
      }

      .success {
         color: green;
         text-align: center;
      }
   </style>

   <!-- JS for proper BACK -->
   <script>
      function goBack(){
         if(document.referrer !== ""){
            window.history.back();
         } else {
            window.location.href = "home.php";
         }
      }
   </script>

</head>
<body>

<div class="box">

   <!-- BACK BUTTON -->
   <a class="back-btn" onclick="goBack()">← Back</a>

   <h2>Customize Your Bouquet 🌸</h2>

   <?php
   if(isset($success)){
      echo "<p class='success'>$success</p>";
   }
   ?>

   <form method="POST">

      <label>Flower Type:</label>
      <select name="flower_type">
         <option>Rose</option>
         <option>Lotus</option>
         <option>Daisy</option>
         <option>Aster</option>
         <option>Marigold</option>
      </select>

      <label>Quantity:</label>
      <input type="number" name="quantity" required>

      <label>Color:</label>
      <select name="color">
         <option>Red</option>
         <option>White</option>
         <option>Pink</option>
         <option>Yellow</option>
      </select>

      <label>Wrapping Style:</label>
      <select name="wrapping">
         <option>Paper</option>
         <option>Net</option>
         <option>Premium</option>
      </select>

      <label>Message:</label>
      <input type="text" name="message">

      <input type="submit" name="submit" value="Place Custom Order" class="btn">

   </form>

</div>

</body>
</html>