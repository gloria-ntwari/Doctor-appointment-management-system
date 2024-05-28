<?php
session_start();


error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="hsp.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lexend Tera&&Lato">
    <style>
        form{
            margin-left: -600px;
        }
        .meeh{
            margin-left: 700px;
            margin-top: 200px;
        }
        .one,.two,.three,.four{
            margin-top: 20px;
            margin-bottom: 20px;
        }
        input{
            width: 300px;
            height: 50px;
        }
    </style>
</head>
<body>
<header>
        <div class="logo">
            <img src="Screenshot_2024-05-02_213736-removebg-preview.png">
            <p><span class="green">Doc</span><span class="blue">Appoint</span></p>
        </div>
        <ul>
            <li><a href="../Home/hsp.php">Home</a></li>
            <li><a href="../About/About.php">About Us</a></li>
            <li><a href="../Department/Depart.php">Departments</a></li>
            <li><a href="check.php">Book Appartments</a></li>
            <li><a href="../celia/form.php">Login</a></li>
        </ul>
    </header>
<form  action="check.php" method='post' style="margin-left:10%;margin-top:20%">
            <label for="search">Search by Appointment No./Name/Mobile No.</label><br>
            <input type="text" placeholder="Appointment No/Name/Mobile No." id="search" name="search"><br><br><br>
            <input type="submit" name="get" value="submit" id="submission">
          </form>

          <?php
$sdata = ''; 
if(isset($_POST['get'])){
    $sdata = $_POST['search'];
    include 'conn.php';
    $id = $_SESSION['user_id'];
    $sdata = $conn->real_escape_string($sdata);
    $id = (int) $id; // Ensure $id is an integer for security

    // Construct and execute the SQL query
    $sql = "SELECT * FROM appointmenttbl2 WHERE (appointNumber LIKE '%$sdata%' OR user_name LIKE '%$sdata' OR mobileNumber LIKE '%$sdata') AND doctor_id = $id";
    $result = $conn->query($sql); 
    
    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Appointment number</th>
                    <th>Patient name</th>
                    <th>Phone number</th>
                    <th>Patient email</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Department Name</th>
                    <th>Doctor name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Output each row of the result
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['appointNumber']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['mobileNumber']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['appointDate']; ?></td>
                    <td><?php echo $row['appointTime']; ?></td>
                    <td><?php echo $row['specialisation']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    } else {
        // No results found
        echo "No results";
    }
}
?>

<?php

if(isset($_POST['submit'])){
    $user_name=$_POST['user_name'];
    $mobilenumber=$_POST['tel'];
    $user_email=$_POST['user_email'];
    $appdate=$_POST['appt_date'];
    $apptime=$_POST['appt_time'];
    $doctorList=$_POST['doctorlist'];
    $specialisation=$_POST['specialisation'];
    $message=$_POST['user_message'];
    $aptnumber=mt_rand(100000,999999);


    $error=array();


    if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
        array_push($error, "Insert a valid email please");
    }

    include 'conn.php';

    $sql = "SELECT * FROM appointmenttbl2 WHERE user_email='$user_email'";
    $result = $conn->query($sql);
    $rowCount = mysqli_num_rows($result);

    if($rowCount > 0){
        array_push($error, "The email already exists"); 
    }

    if(count($error) > 0){
        foreach($error as $errors){
            echo "<div class='alert alert-danger'>$errors</div>";
        }
    }
    else{

        $sql = "INSERT INTO appointmenttbl2(appointNumber,user_name,mobileNumber,user_email,appointDate,appointTime,user_message,doctor_id,specialisation) VALUES 
        ('$aptnumber', '$user_name', '$mobilenumber','$user_email','$appdate','$apptime','$message','$doctorList','$specialisation')";   
        $result = $conn->query($sql);
        if($result === TRUE){
            echo "<div class='alert alert-success'>Your appointment has been recived successfully</div>";
        }  
        else{
            echo 'Error: '.$sql.'<br>'.$conn->error;
        }
    }
}

?>


    

<div class="meeh">

    <form action="check.php" method="post" style="margin-top:-80px">
        <h1>Book an appointment</h1>
        <div class="one">
            <input type="text" placeholder="Enter your name" name="user_name">
            <input type="email" placeholder="Enter your email" name="user_email">
        </div>
        <div class="two">
            <input type="tel" placeholder="Enter your phonenumber" name="tel">
            <input type="date" name="appt_date">
        </div>
        <div class="three">
            <input type="time" name="appt_time">


<select style="width:300px; height: 50px;" name="specialisation">
<option value="">Select department</option>
    <?php
    include 'conn.php';
    $sql = "SELECT * FROM specialisationtbl2";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $specialisation = $row['Specialisation'];
        $sp_id=$row['id'];
        ?>
        <option value="<?php echo $specialisation?>"><?php echo $specialisation; ?></option>
        <?php
    }
    ?>
</select>
        </div>
        <div class="four">
        <select style="width:300px; height: 50px;" name="doctorlist">
<option value="">Select doctor</option>
    <?php
    include 'conn.php';
    $sql = "SELECT * FROM doctortbl2 ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $doctor_name = $row['doctor_name'];
        $doc_id=$row['id'];
        ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $doctor_name; ?></option>
        <?php
    }
    ?>
</select>
            <div class="two">
            <input type="text" placeholder="Enter your message" name="user_message">
        </div>
             <input type="submit" name="submit" value="book">
    
            </form>
</div>

<p class="Results3">Subscribe to our news letter</p>
<button  class="Results4"><p style="margin-left: 20px;font-size: 15px;">Enter your email</p></button>
<button class="sub">Subscribe</button>
</div>
<footer>
    <div class="products">
        <div class="upper">
            <div class="logo1">
                <img src="Screenshot_2024-05-02_213736-removebg-preview.png">
                <p><span class="green">Doc</span><span class="blue">Appoint</span></p>
            </div>
  <p style="margin-top: 20px;">Copyright C 2022 BRIX Templates</p>
   <p>| All Rights Reserved</p>
        </div>
        <div class="upper" style="margin-left: 50px;">
            <h1>Product</h1>
            <p style="margin-top: 30px;">Features</p>
            <p>Pricing</p>
            <p>Case studies</p>
            <p>Reviews</p>
            <p>Updates</p>
        </div>
        <div class="upper" style="margin-left: -50px;">
            <h1>Company</h1>
            <p  style="margin-top: 30px;">About</p>
            <p>Contact</p>
            <p>Careers</p>
            <p>Culture</p>
            <p>Blog</p>
        </div>
        <div class="upper" style="margin-left: -20px;">
            <h1>Support</h1>
            <p  style="margin-top: 30px;">Getting started</p>
            <p>Help center</p>
            <p>Server Status</p>
            <p>Report a bug</p>
            <p>Chat Support</p>
        </div>
        <div class="upper" style="margin-left: -30px;">
            <h1>Follow us</h1>
            <p  style="margin-top: 30px;">Facebbok</p>
            <p>Twitter</p>
            <p>Instagram</p>
            <p>Luinkedin</p>
            <p>You Tube</p>
        </div>
    </div>
</footer>
</body>
</html>


