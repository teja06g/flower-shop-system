<?php

@include 'config.php';

$message = []; // Initialize $message as an array
$registration_successful = false; // Track registration success

if (isset($_POST['submit'])) {
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
    } else {
        if ($name == '') {
            $message[] = 'Name is required!';
        } elseif ($pass !== $cpass) {
            $message[] = 'Passwords do not match!';
        } else {
            mysqli_query($conn, "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$pass')") or die('query failed');
            $registration_successful = true; // Set success flag
            // $message[] = 'Registered successfully!'; // Add success message
            // header('location:login.php');
            // exit; // Uncomment to redirect after registration
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

    <script>
        // Function to show alert on successful registration
        function showAlert() {
            alert("Registered successfully!");
        }

        // Check if the registration was successful
        window.onload = function() {
            const registrationSuccessful = <?php echo json_encode($registration_successful); ?>;
            if (registrationSuccessful) {
                showAlert();
            }
        };
    </script>
</head>
<body>

<?php
if (isset($message) && is_array($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>'.$msg.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<section class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
        <input type="text" name="name" class="box" placeholder="Enter Your Username" required>
        <input type="email" name="email" class="box" placeholder="Enter Your Email" required>
        <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
        <input type="password" name="cpass" class="box" placeholder="Confirm Your Password" required>
        <input type="submit" class="btn" name="submit" value="Register Now">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</section>

</body>
</html>
