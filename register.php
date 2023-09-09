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
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel= "stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h2>Kroll Villa Reservations</h2>

    <div class="container">
        <form action="register.php" method="post">


            


            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Full Name">
            </div>

            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email Address">
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password">
            </div>

            <div class="form-btn">
                <input type="submit" value="Register Now" name="submit" class="btn btn-primary">
            </div>
            <br>
            <div>
                <p>Already Registered?<a href="login.php"> Log Now</a></p>
            </div>

           

            <?php
                if(isset($_POST["submit"])){

                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $repeat_password = $_POST["repeat_password"];

                    $passwordHash = password_hash($password, PASSWORD_DEFAULT); //security eka wadi wenwa hash daddi url widihata yanne

                    $errors = array();

                    if(empty($name) || empty($email) || empty($password) || empty($repeat_password)){
                        array_push($errors, "All fillings are required!");
                    }
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        array_push($errors, "Email is invalid");
                    }
                    if(strlen($password<8)){
                        array_push($errors, "Password must be containe at least 8 characters.");
                    }
                    if($password !== $repeat_password){
                        array_push($errors, "Passwords doe not match.");
                    }

                    require_once "database.php";

                    $sql = "SELECT * FROM users WHERE email='$email'";
                    $result = mysqli_query($conn, $sql);
                    $rowCount = mysqli_num_rows($result);
                    if($rowCount > 0){

                        array_push($errors,"Email is already exist!");
                    }

                    if(count($errors) > 0){
                        foreach ($errors as $error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }

                    }else{
                        
                        $sql = "INSERT INTO users(full_name, email, password)VALUES(?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        $stmtPrepare = mysqli_stmt_prepare($stmt, $sql);

                        if($stmtPrepare){
                            mysqli_stmt_bind_param($stmt,"sss",$name, $email, $passwordHash);
                            mysqli_stmt_execute($stmt);
                            echo "<div class='alert alert-success'>Registration Successfull.<div>";

                        }else{
                            die ("Something went wrong!");
                        }
                    }
                }

            ?>

        </form>
    </div> 
</body>
</html>