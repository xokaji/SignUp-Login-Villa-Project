<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel= "stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h2>Kroll Villa Reservations</h2>
    <div class="container">
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address">
            </div>

            <div class="form-group">
                <input type="passsword" class="form-control" name="password" placeholder="Password">
            </div>

            <div class="form-btn">
                <input type="submit" value="Login" class="btn btn-primary" name="login">
            </div>

            <div>
                <br>
                <p>Not Registered Yet? <a href="register.php">Register Now</a></p>
            </div>

            <?php

                 

                if(isset($_POST["login"])){
                    $email=$_POST["email"];
                    $password = $_POST["password"];

                    $wrongs= array();

                    require_once "database.php";
                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $result = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if ($user){
                        if(password_verify($password, $user["password"])){
                            session_start();
                            $_SESSION["user"] = "yes";
                            header("Location: index.php");
                            die();
                        }else{
                            echo "<br><br>";
                            echo "<div class='alert alert-danger'>Password not match!</div>";
                        }
                    }else{
                        echo "<div class='alert alert-danger'>Email not match!</div>";
                    }
                   
                }

            ?>
        </form>
    </div>
</body>
</html>