<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imboni Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){
            $email = $_POST["email"];
            $pin = $_POST["pin"];
            require_once "database.php";
            $sql = "SELECT *FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
              if(password_verify($pin, $user["password"])){
                header("location: index.php");
                die("something went wrong");
              }else{
                echo "<div class='alert alert-danger'>Wrong Password!</div>";
              }
            }else{
                echo "<div class='alert alert-danger'>Email doesnt exist!</div>";
            }
        }
         ?>
        <form action="login.php" method="post">
        <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pin" placeholder="Enter password:">
            </div>
            <div class="btn btn-primary">
               <input type="submit" class="btn btn-primary" value="Login" name="submit">
            </div>

        </form>
        <a href="registration.php"> Don't have account ? Register</a>
    </div>
    
</body>
</html>