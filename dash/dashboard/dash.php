
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
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

  <?php
session_start();


error_reporting(0);
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
  header('location:../logout/logout.php');
  exit();
}
?>


    <div class="sidebar">
      <div class="logo"></div>
      <ul class="menu">
        <li class="Active">
          <a href="dash.php">
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
          <a href="../pass/pass.php">
            <i class="fas fa-star"></i>
            <span>Password</span>
          </a>
        </li>
        <li>
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
          <span>Doctor</span>
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
  <h3 class="main--title">Today's data</h3>
  <div class="card--wrapper">
    <div class="payment--card light-red" >
      <div class="card--header">
        <span class="title" >Approved appointments</span>
        
        <span class="amount-value">
          <?php
        include "approved.php";
        echo $approv;
          ?></span>
      </div>
    </div>
  </div>


  <div class="card--wrapper">
    <div class="payment--card light-blue">
      <div class="card--header">
        <span class="title">Cancelled appointments</span>
         
        <span class="amount-value"> 
                <?php 
                  include 'cacelled.php';
                   echo $count;
                   ?></span>
      </div>
    </div>
  </div>



  <div class="card--wrapper">
    <div class="payment--card light-red">
      <div class="card--header">
        <span class="title">Total appointments</span>
<span class="amount-value"><?php
              include 'total.php';
              echo $total;
              ?></span>
      </div>
    </div>
  </div>



  <div class="card--wrapper">
    <div class="payment--card light-blue">
      <div class="card--header">
        <span class="title">New appointments</span>
        
        <span class="amount-value">
        <span class="amount-value"><?php
              include 'new.php';
              echo $new;
               ?></span>
      </div>
    </div>
  </div>
</div>

            
  </body>
</html>