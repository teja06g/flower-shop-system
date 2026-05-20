<?php
@include 'config.php';

$query = "SELECT MONTH(placed_on) as month, SUM(total_price) as profit 
FROM orders 
WHERE payment_status='completed'
GROUP BY MONTH(placed_on)";

$result = mysqli_query($conn,$query);

$months = [];
$profits = [];

while($row = mysqli_fetch_assoc($result)){
   $months[] = $row['month'];
   $profits[] = $row['profit'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profit Graph</title>

<!-- same css as admin dashboard -->
<link rel="stylesheet" href="css/admin_style.css">

<!-- chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

.graph-container{
   width:80%;
   margin:40px auto;
   background:white;
   padding:30px;
   border-radius:10px;
   box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.graph-title{
   text-align:center;
   font-size:28px;
   margin-bottom:20px;
}

</style>

</head>

<body>

<?php @include 'admin_header.php'; ?>

<section class="dashboard">

<div class="graph-container">

<h1 class="graph-title">Monthly Profit Report</h1>

<canvas id="profitChart"></canvas>

</div>

</section>

<script>

var ctx = document.getElementById('profitChart').getContext('2d');

var chart = new Chart(ctx,{
type:'bar',
data:{
labels: <?php echo json_encode($months); ?>,
datasets:[{
label:'Monthly Profit (₹)',
data: <?php echo json_encode($profits); ?>,
backgroundColor:'#8e44ad'
}]
},
options:{
responsive:true,
plugins:{
legend:{
display:true
}
}
}
});

</script>

</body>
</html>