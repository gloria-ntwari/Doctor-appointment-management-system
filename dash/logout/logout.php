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
<?php
session_start();
session_unset();
session_destroy();
header('location:../../PHP project/Home/hsp.php');

?>
        </div>
        <div class="tabular--wrapper">
          <div class="table-container"></div>
        </div>
      </div>
    </div>
  </body>
</html>