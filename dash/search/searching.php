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
    <link rel="stylesheet" href="apt.css" />
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
          <a href="searching.php">
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
          <a href="../pass/pass.php">
            <i class="fas fa-star"></i>
            <span>Password</span>
          </a>
        </li>
        <li class="../logout/logout">
          <a href="#">
            <i class="fas fa-sign-out-alt"></i>
            <span>logout</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="main--content">
      <div class="header--wrapper">
        <div class="header--title">
          <span>Admin</span>
          <h2>Dashboard</h2>
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
          <form  method='post'>
            <label for="search">Search by Appointment No./Name/Mobile No.</label><br>
            <input type="text" placeholder="Appointment No/Name/Mobile No." id="search" name="search"><br><br><br>
            <input type="submit" name="submit" value="submit" id="submission">
          </form>
          <?php
$sdata = ''; 
if (isset($_POST['submit'])) {
    $sdata = $_POST['search'];
    include 'conn.php';
    
    // Ensure the session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Get user_id from session
    $id = $_SESSION['user_id']; // Correct session variable usage

    // Sanitize inputs to prevent SQL injection
    $sdata = $conn->real_escape_string($sdata);
    $id = (int) $id; // Cast to integer

    // Construct SQL query
    $sql = "SELECT * FROM appointmenttbl2 
            WHERE (appointNumber LIKE '%$sdata%' 
                   OR user_name LIKE '%$sdata%' 
                   OR mobileNumber LIKE '%$sdata%') 
              AND doctor_id = $id";
    
    // Debug: print SQL query
    // echo $sql;

    // Execute the query
    $result = $conn->query($sql); 
    
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
        echo "No results";
    }
}
?>

        </div>
        <div class="tabular--wrapper">
          <div class="table-container"></div>
        </div>
      </div>
    </div>
  </body>
</html>
