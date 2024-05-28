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
          <a href="profile.php">
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
        <h3 class="main--title">Change your Profile <br></h3>

        <?php
        include 'conn.php';
        
        $id = $_SESSION['user_id'];
        $sql="SELECT doctor_name , doc_email, doc_password FROM doctortbl2 WHERE id=$id";
        $result=$conn->query($sql);
       
        if($row=$result->fetch_assoc()){
        ?>

        <form  action="profile.php" method='post'>
            <label for="from" style="margin-top: 40px;">Doctor Name</label><br>
            <input type="text" value="<?php echo $row['doctor_name'];?>" id="from" name="doc_name"><br><br>
            <label for="to">Doctor Email</label><br>
            <input type="text" value="<?php echo  $row['doc_email'];?>" id="to" name="doc_email"><br><br>
            <input type="submit" name="submit" value="Update" id="submission">
          </form>

          <?php
          }else{
            echo "The doctor was not found";
          }
          ?>

<?php
            if (isset($_POST['submit'])) {
                $doc_name = $_POST['doc_name'];
                $doc_email = $_POST['doc_email'];

                if (empty($doc_name) || empty($doc_email)) {
                    echo "Name and email are required";
                } else {
                    $update_sql = "UPDATE doctortbl2 SET doctor_name = ?, doc_email = ? WHERE id = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param("ssi", $doc_name, $doc_email, $id);

                    if ($update_stmt->execute()) {
                      echo "<div class='alert alert-danger'>Your record was updated successfully</div>";
                    } else {
                        echo "Error: " . $update_stmt->error;
                    }

                    $update_stmt->close();
                }
            }

            $stmt->close();
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