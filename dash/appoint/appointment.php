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
    <link rel="stylesheet" href="profile.css" />
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
          <a href="appointment.php">
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
          <a href="../pass/pass.php">
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
          
        </div>
        <div class="tabular--wrapper">
          <div class="table-container"></div>

          <?php

include 'conn.php';
$id = $_SESSION['user_id'];
// if($query->rowCount() > 0)
$sql = "SELECT * FROM appointmenttbl2 WHERE doctor_id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    ?>
    <table>

            <tbody>
            <tr>
        <th>Appointment number</th>
        <td><?php echo $row['appointNumber']; ?></td>
        <th>Patient name</th>
        <td><?php echo $row['user_name']; ?></td>
      </tr>
      <tr>
        <th>Phone number</th>
        <td><?php echo $row['mobileNumber']; ?></td>
        <th>Patient email</th>
        <td><?php echo $row['user_email']; ?></td>
      </tr>
      <tr>
        <th>AppointmentDate</th>
        <td><?php echo $row['appointDate']; ?></td>
        <th>Appointment Time</th>
        <td><?php echo $row['appointTime']; ?></td>
      </tr>
      <tr>
        <th>Department</th>
        <td><?php echo $row['specialisation']; ?></td>
      </tr>
      <tr>
                <th>Message</th>
                <td><?php echo $row['user_message']; ?></td>
                <th>Status</th>
                <td><?php $status=$row['status'];
                    
$status = $row['status'];

if ($status == "") {
  echo "Not yet updated";
}

if ($status == "Approved") {
  echo "Your appointment has been approved";
}

if ($status == "Cancelled") {
  echo "Your appointment has been cancelled";
}
?></td>
              </tr>
            </tbody>
            <?php }} 
            echo "<hr><br><br><br><br>";
            ?>
          </table>

<?php 
if ($status=="" ){
?> 
<p align="center"  style="padding-top: 20px">                            

<?php } ?>
<?php
include 'conn.php';
$id = $_SESSION['user_id'];

$sql = "SELECT * FROM appointmenttbl2 WHERE id=?";
$result = $conn->query($sql);
 $row = $result->fetch_assoc() ;
 
  ?>
<form method="post" name="updateForm">

            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
            <tr>
              <th>Status:</th>
              <td>
                <select name="status" required="true">
                  <option value="Approved" selected="true">Approved</option>
                  <option value="Cancelled">Cancelled</option>
                </select>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <button type="submit" name="updateButton" class="btn btn-primary">Update</button>
              </td>
            </tr>
          </form>
<?php
if (isset($_POST['updateButton'])) {

  $status = $_POST['status'];
  $id = $_POST['id'];


  // Ensure that the id value is not empty
  if (!empty($id)) {
    $sql = "UPDATE appointmenttbl2 SET status='$status' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
      echo "Status updated successfully.";
    } else {
      echo "Error updating status: " . $conn->error;
    }
  } else {
    echo "Error: Invalid appointment ID.";
  }
}
?>
        </div>
      </div>
    </div>
  </body>
</html>


