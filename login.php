<?php
session_start();
require('connection.php');

if(isset($_POST['login'])){
    $_SESSION['validate'] = false;
    $username = $_POST['username'];
    $password = $_POST['password'];

    $p = teledoc::connect()->prepare('SELECT * FROM info WHERE name=:u AND user_type=2');
    $p->bindValue(':u', $username);
    $p->execute();
    $user = $p->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $storedPassword = $user['pass'];
        
        if ($password === $storedPassword) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id']=$user['id'];
            $_SESSION['validate'] = true;
            echo '<script>alert("You have been logged in!");</script>';
            header('Location: index.php');
            exit;
        } else {  
            $error_message = "Password mismatch!";
        }
    } else {
        $error_message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DocSpot</title>


    <!-- Custom CSS -->
    <style>
        /* Navbar */
        .navbar {
            background-image: url('bg2.jpg'); /* Add background image */
            background-size: cover;
            background-position: center;
            padding: 2px;
            border-radius: 10px;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-size: 30px; 
            text-decoration: none;/* Change navbar brand text color */
        }

        .navbar-nav .nav-link {
            color: #333 !important; /* Change navbar links text color */
        }

        body {
            background-image: url('4077.jpg'); /* Add background image */
            background-size: 2200px;
            background-position: center;
        }
        /* Main Content */
        .main-content {
            background-image: url('bg2.jpg'); /* Add background image */
            background-size: cover;
            background-position: center;
            padding: 30px;
            border-radius: 10px;
            margin-top: 20px; /* Add margin to the top */
        }

        /* Text */
        h1, h2, h3, h4, h5, h6 {
            color: #3f51b5; /* Change heading text color */
        }

        p {
            color: #333; /* Change paragraph text color */
        }
        .navbar-nav .nav-link {
            text-decoration: none; /* Remove underline */
        }


    </style>
</head>
<body>

<?php
require "navbar.php";
?>
    <!-- Main Content -->
    <div class="container mt-5 main-content">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Login to DocSpot</h1>
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input required type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <br><label for="password" class="form-label">Password</label>
                        <input required type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary" value="login_button" name="login">Login</button>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php">Register Here!</a></p>
            </div>
        </div>
    </div>

  

























    


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
</body>
</html>
