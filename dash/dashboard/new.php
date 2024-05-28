
<?php
session_start();
error_reporting(0);

include 'conn.php'; 
$id = intval($_GET['id']);
$sql = "SELECT * FROM appointmenttbl2 WHERE  status='' AND doctor_id=$id";
$result = $conn->query($sql);

$new= 0; 

if (mysqli_num_rows($result) > 0) {

    while ($row = $result->fetch_assoc()) {
        $new++; 
    }
} else {
    $new= 0;
}
$conn->close();

?>
<!-- <form action="dash.php?approv=<?php echo $approv; ?>" method="post">
    <button type="submit">Submit</button>
</form> -->
