<?php
// Start the session to remember the admin
session_start();
$error = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace these with whatever username/password you want
    if ($username === 'admin' && $password === '12345') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php"); // Send them to the dashboard
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | LeMovie</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body style="background-color: #f4f7f6 !important;"> <nav class="navbar">
        <div class="navbar__container">
            <a href="index.html" id="navbar__logo">LeMovie</a>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="index.html" class="navbar__links">HOME</a></li>
            </ul>
        </div>
    </nav>

    <div style="display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 100px); padding: 20px;">
        
        <div class="login-container">
            <h2 class="login-title">ADMIN ACCESS</h2>
            <p class="login-subtitle">Please enter your credentials to continue.</p>
            
            <?php if($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="" class="login-form">
                <input type="text" name="username" class="login-input" placeholder="Username" required>
                <input type="password" name="password" class="login-input" placeholder="Password" required>
                <button type="submit" class="login-btn">LOGIN</button>
            </form>
        </div>

    </div>

</body>
</html>
