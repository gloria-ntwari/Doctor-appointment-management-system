<?php
session_start();
include 'conn.php';

// Sign-Up Form Handling
if(isset($_POST['submit'])){
    $firstName = $_POST['fullName'];
    $Email = $_POST['email'];
    $user_password = $_POST['user_password'];

    $error = array();

    if(empty($firstName) || empty($Email) || empty($user_password)){
        array_push($error, "All fields are required");
    }
    if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
        array_push($error, "Insert a valid email please");
    }

    // SQL Injection Vulnerability: Direct use of user inputs in query
    $sql = "SELECT * FROM doctortbl2 WHERE doc_email='$Email'";
    $result = $conn->query($sql);
    $rowCount = mysqli_num_rows($result);

    if($rowCount > 0){
        array_push($error, "The email already exists"); 
    }

    if(count($error) > 0){
        foreach($error as $errors){
            echo "<div class='alert alert-danger'>$errors</div>";
        }
    } else {
        // Insecure password hashing
        $hashedPassword = md5($user_password);

        $sql = "INSERT INTO doctortbl2(doctor_name, doc_email, doc_password) VALUES ('$firstName', '$Email', '$hashedPassword')";   
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>You have registered successfully</div>";
        } else {
            echo 'Error: '.$sql.'<br>'.$conn->error;
        }
    }
}

// Sign-In Form Handling
if(isset($_POST["login"])){
    $Email = $_POST['email'];
    $user_password= $_POST['user_password'];
    $hashedPassword = md5($user_password);

    // SQL Injection Vulnerability: Direct use of user inputs in query
    $sql = "SELECT id FROM doctortbl2 WHERE doc_email='$Email' AND doc_password='$hashedPassword'";
   
    $result = $conn->query($sql);

    // Incorrect placement of session start and result check
    while($row = $result->fetch_assoc()){

        session_start(); // Redundant session_start
        $id = $row['id'];
        session_regenerate_id();
        $_SESSION["user_id"] = $id;
      
        if($result){
            header("Location: ./../../dash/dashboard/dash.php?id=$id");
            die();
        }
    }

    
    // The error message should be here
    if(($result->num_rows) > 0){
        echo "<div class='alert alert-danger'>Incorrect email or password</div>";

}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliding Login Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
</head>
<body>
    <div class="container" id="main">
        <div class="sign-up">
            <form action="form.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <p>or use your email for registration</p>
                <input type="text" name="fullName" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="user_password" placeholder="Password" required>
                <button type="submit" name="submit">Sign Up</button>
            </form>
        </div>

        <div class="sign-in">
            <form action="form.php" method="POST">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <p>or use your account</p>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="user_password" placeholder="Password" required>
                <a href="#">Forget your password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-left">
                    <h1>Welcome Back</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button id="signIn">Sign In</button>
                </div>
                <div class="overlay-right">
                    <h1>Hello, Friend</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const main = document.getElementById('main');

        signUpButton.addEventListener('click', () => {
            main.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            main.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>
