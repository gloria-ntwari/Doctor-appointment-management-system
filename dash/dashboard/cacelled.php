<?php
session_start();
error_reporting(0);

include 'conn.php'; 
$id = intval($_GET['id']);
$sql = "SELECT * FROM appointmenttbl2 WHERE status='Cancelled' AND doctor_id=$id";
$result = $conn->query($sql);
$count= 0; 

if (mysqli_num_rows($result) > 0) {

    while ($row = $result->fetch_assoc()) {
        $count++; 
    }
} else {
    $count = 0;
}
$conn->close();

?>
<!-- <form action="dash.php?approv=<?php echo $count; ?>" method="post">
    <button type="submit">Submit</button>
</form> -->

