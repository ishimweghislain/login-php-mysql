<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imboni login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){

            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $pin = $_POST["pin"];
            $repeatpin = $_POST["repeatpin"];
            $password_hash = password_hash($pin, PASSWORD_DEFAULT);


            $errors = array();
           // this validation checks if all fields were fulfilled by the user.
            if(empty($fullname) OR empty($email) OR empty($fullname) OR empty($pin) OR empty($repeatpin)){
               array_push($errors, "Please Fill all fields");
            }
           
            // this validation now checks if email is validated
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors, "Email is not valid");
            }

            // this validates on your password
            if(strlen($pin)<8){
                array_push($errors, "Pin must be at least 8 characters");
            }

            // validation now to check if passwords match
            if($pin!==$repeatpin){
                array_push($errors, "Confirm well your pin.");
            }
            require_once "database.php";
            $sql = "SELECT *FROM users WHERE email ='$email'";
            $result = mysqli_query($conn, $sql);
            $rowcount = mysqli_num_rows($result);
            if( $rowcount>0){
                array_push($errors, "Email already exists");
            }


            if(count($errors)>0){
                foreach ($errors as $error){
                    echo "<div class='alert alert-danger custom-alert'>$error</div>";
                }
            }else{
        
            $sql = "INSERT INTO users (full_name, email, password) VALUES ('$fullname', '$email', '$password_hash')";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
               die("something went wrong");
            }
    
            // Close the database connection
            mysqli_close($conn);
        }
    }
        
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Fullname:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pin" placeholder="Enter password:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="repeatpin" placeholder="Repeat password:">
            </div>
            <div class="btn btn-primary">
               <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        
        </form>
        <a href="login.php"> Already have account ? login</a>
    </div>
</body>
</html>