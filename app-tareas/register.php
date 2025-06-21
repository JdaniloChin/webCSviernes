<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email format</div>";
    } elseif ($password !== $confirm_password) {
        echo "<div class='alert alert-danger'>Passwords do not match</div>";
    } else {
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("Location: index.html");
        exit();
    }
}else{
    // If the request method is not POST, redirect to the registration page
    header("Location: register.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 shadow-lg w-100" style="max-width: 400px;">
            <h3 class="card-title text-center mb-4">Register </h3>
            <form id="register-form" method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group mb-3">    
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>               
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
                </div>
                <div class="input-group mb-3">    
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>               
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <!-- <div id="register-error" class="text-danger mt-3" style="display: none;">Password and confimation don't match</div> -->
            <div id="register-error" class="mt-3"></div>
            <p class="text-center mt-3">You already have a account? <a href="./index.html">Login here</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>