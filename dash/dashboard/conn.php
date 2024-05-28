
<?php
$servername='localhost';
$username='root';
$password='';
$dbname ='appointment';
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
    echo " Connected failed ";
}
?>

