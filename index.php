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


if (isset($_POST['btn_login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM user WHERE username ='$username'  AND password ='$password' ";

  $result = mysqli_query($conn, $sql);



  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);



    if ($row['username'] == $username and $row['password'] == $password and $row['role'] == "admin") {

      $_SESSION['id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['role'] = $row['role'];

      echo '<script type="text/javascript">';
      echo ' alert("Login Succeed")';
      echo '</script>';
      header('Location:dashboard.php');
    } else if ($row['username'] == $username and $row['password'] == $password and $row['role'] == "Sales Represent") {

      $_SESSION['username'] = $row['username'];
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['role'] = $row['role'];

      echo '<script type="text/javascript">';
      echo ' alert("Login Succeed")';
      echo '</script>';
      header('Location:dashboard.php');
    } else {
      echo '<script>alert("Failed to sign in!")</script>';
    }
  } else {
    echo '<script>alert("Invalid username or password!")</script>';
  }
}
?>




<!DOCTYPE html>
<html>

<head>
  <title>POS | Log in</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div id="login">
    <h3 class="text-center text-white pt-5"> <b>Tally Note</b></h3>
    <hr>
    <div class="container">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-12">
          <form id="login-form" class="form" action="" method="POST">
            <h3 class="text-center text-info">Login</h3>
            <div class="form-group">
              <label for="username" class="text-info">Username:</label><br>
              <input type="text" name="username" required class="form-control">
            </div>
            <div class="form-group">
              <label for="password" class="text-info">Password:</label><br>
              <input type="password" name="password" required class="form-control">
            </div>
            <div class="form-group">
              <input type="submit" name="btn_login" class="btn btn-info btn-md" value="Login">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>