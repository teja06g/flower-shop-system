<?php
@include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
   <title>Custom Orders</title>

   <style>
      body {
         font-family: Arial;
         background: #f5f5f5;
      }

      h2 {
         text-align: center;
         margin-top: 20px;
         color: #e84393;
      }

      table {
         width: 90%;
         margin: 30px auto;
         border-collapse: collapse;
         background: white;
         box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }

      th, td {
         padding: 12px;
         border: 1px solid #ddd;
         text-align: center;
      }

      th {
         background: #e84393;
         color: white;
      }

      tr:nth-child(even) {
         background: #f9f9f9;
      }

      .btn {
         padding: 6px 12px;
         background: #e84393;
         color: white;
         text-decoration: none;
         border-radius: 4px;
      }

      .btn:hover {
         background: #d6307a;
      }

      .back {
         display: block;
         width: fit-content;
         margin: 20px auto;
         text-decoration: none;
         color: #e84393;
      }
   </style>

</head>
<body>

<h2>Customer Customization Requests 🌸</h2>

<a href="admin_customize.php" class="back">← Back to Admin Panel</a>

<table>
   <tr>
      <th>ID</th>
      <th>Flower</th>
      <th>Quantity</th>
      <th>Color</th>
      <th>Wrapping</th>
      <th>Message</th>
      <th>Action</th>
   </tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM custom_orders");

if(mysqli_num_rows($result) > 0){
   while($row = mysqli_fetch_assoc($result)){
?>

   <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['flower_type']; ?></td>
      <td><?php echo $row['quantity']; ?></td>
      <td><?php echo $row['color']; ?></td>
      <td><?php echo $row['wrapping']; ?></td>
      <td><?php echo $row['message']; ?></td>

      <!-- Customize Button -->
      <td>
         <a href="admin_customize.php" class="btn">Customize</a>
      </td>
   </tr>

<?php
   }
}else{
   echo "<tr><td colspan='7'>No Custom Orders Found</td></tr>";
}
?>

</table>

</body>
</html>