<?php
 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
    
    session_start();
 if($_SESSION['role']!=="Admin"){
   header('location:index.php');
 }
 
 $sql="DELETE FROM invoice WHERE invoice_id='".$_GET['id']." '  ";

if($conn->query($sql)== TRUE){

    echo '<script type="text/javascript">';
    echo ' alert("Transction Deleted")';
    echo '</script>';
    header('location:order.php');
}
else {
    echo '<script type="text/javascript">';
    echo ' alert("frustration")';
    echo '</script>';
   
}

?>
