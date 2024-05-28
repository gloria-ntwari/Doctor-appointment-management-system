<?php
session_start();


error_reporting(0);
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  header('location:../logout/logout.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashbord</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="pass.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo"></div>
      <ul class="menu">
        <li class="Active">
          <a href="../dashboard/dash.php">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashbord</span>
          </a>
        </li>
        <li>
          <a href="../appoint/appointment.php">
            <i class="fas fa-chart-bar"></i>
            <span>Appointments</span>
          </a>
        </li>
        <li>
          <a href="../search/searching.php">
            <i class="fas fa-briefcase"></i>
            <span>Search</span>
          </a>
        </li>
        <li>
          <a href="../reports/report.php">
            <i class="fas fa-star"></i>
            <span>Reports</span>
          </a>
        </li>
        <li>
          <a href="../profile/profile.php">
            <i class="fa-solid fa-user"></i>
            <span>Profile
            </span>
          </a>
        </li>
        <li>
          <a href="pass.php">
            <i class="fas fa-star"></i>
            <span>Password</span>
          </a>
        </li>
        <li class="logout">
          <a href="../logout/logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>logout</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="main--content">
      <div class="header--wrapper">
        <div class="header--title">
          <span>Doctor </span>
          <h2>Profile</h2>
        </div>
        <div class="user--info">
          <div class="search--box">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Search" />
          </div>
          <img src="" alt="" />
        </div>
      </div>
      <div class="card--container">
        <div class="card--wrapper">
        <h3 class="main--title">Change your Password<br></h3>

        <form  action="pass.php" method='post'>
            <label for="from" style="margin-top: 40px;">Current Password</label><br>
            <input type="text" value="" placeholder="Current password" id="from" name="cur_pass"><br><br>
            <label for="to">New password</label><br>
            <input type="text" value="" id="to" placeholder="New password" name="new_pass"><br><br>
            <input type="submit" name="submit"  value="Update" id="submission">
          </form>


          <?php
include 'conn.php';

session_start();  // Ensure the session is started
$id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $cur_pass = md5($_POST['cur_pass']);
    $new_pass = md5($_POST['new_pass']);

    if (empty($cur_pass) || empty($new_pass)) {
        echo "All fields are required";
    } else {
        // Check if current password matches the one in the database
        $check_sql = "SELECT doc_password FROM doctortbl2 WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $check_stmt->bind_result($db_cur_pass);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($db_cur_pass != $cur_pass) {
            echo "Current password is incorrect";
        } else {
            // Update the password
            $update_sql = "UPDATE doctortbl2 SET doc_password=? WHERE id=?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_pass, $id);

            if ($update_stmt->execute()) {
                echo "<div class='alert alert-success'>Your password was updated successfully</div>";
            } else {
                echo "Error: " . $update_stmt->error;
            }

            $update_stmt->close();
        }
    }
}

$conn->close();
?>

        </div>
        <div class="tabular--wrapper">
          <div class="table-container"></div>
        </div>
      </div>
    </div>
  </body>
</html>