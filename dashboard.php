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
if ($_SESSION['role'] == "admin") {
  include_once 'admin_dash.php';
} else {
  include_once 'admin_sale.php';
}

?>


<html>

<head>

  <title>Dashboard</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/fontawesome.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>
  <!-- Navbar + login Menu End -->
  <div>
    <nav class="nav-header">
      <div class="nav-user-menu">
        <span class="logout"> <i class="fa fa-circle"></i> <a style="color:#FFF; float:right;" href="logout.php">Log Out</a></span>
      </div>
    </nav>
  </div>
  <!-- Navbar + login Menu End -->



  <!-- Notification Box-->

  <div class="row-1 pt-4*">
    <h4>Hello, <?php echo $_SESSION['fullname']; ?> </h4>
  </div>

  <div class="d-flex justify-content-center align-items-center">

    <!--Limited Stock -->
    <div class="card">
      <span class="icon">
        <i class="fa fa-level-down fa-5x"></i>
      </span>
      <h4>Limited Stock</h4>
      <div class="stock-info">
        <?php
        $sql = "SELECT count(pCode) as total FROM product Where pStock <= minStock";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $tol = $row['total'];
        $total1 = $tol;
        ?>
        <?php if ($total1 == true) { ?>
          <span class="stock-info-number"><b><?php echo $tol; ?></b></span>
        <?php } else { ?>
          <span class="stock-info-text"><b>0</b></span>
        <?php } ?>
      </div>

    </div>

    <!--Reserved Product -->
    <div class="card">
      <span class="icon"><i class="fa fa-truck fa-5x"></i></span>
      <h4>Reserved Products</h4>
      <div class="product-info">
        <?php
        $sql = "SELECT count(pCode) as t FROM product";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $tol = $row['t'];
        $total = $tol;
        print_r($total);
        ?>
      </div>
    </div>


    <!--Todays Transction  -->
    <div class="card">
      <span class="icon"><i class="fa fa-shopping-cart fa-5x"></i></span>
      <h4>Daily Transction</h4>
      <div class="transction-info">
        <?php
        $sql = "SELECT count(invoice_id) as i FROM invoice WHERE order_date=CURDATE() ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $tol = $row['i'];
        $total = $tol;
        print_r($total);
        ?>
      </div>
    </div>

    <!-- Todays Income-->
    <div class="card">
      <span class="icon"><i class="fa fa-line-chart fa-5x"></i></span>
      <h4>Sold Amount</h4>
      <div class="income-info">
        <?php
        $sql = "SELECT sum(total) as total FROM invoice WHERE order_date=CURDATE() ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $tol = $row['total'];
        $total = $tol;
        ?>
        <span class="income-info-number"><b>BDT. <?php echo number_format($total, 0); ?></small></span>

      </div>

    </div>


  </div>


  <!-- Notification Box End-->

  <script src="js/jquery.js"></script>
  <script src="js/script.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>