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
    if($_SESSION['role']=="admin"){
        include_once'admin_dash.php';
    }else{
        include_once'admin_sale.php';
    }

?>


<html>
    <head>

<title>Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/fontawesome.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/all.min.css">


<style>
    .content-b{
        margin-left: 300px ;
        max-width: 1200px;
        width:1200px;
        display: inline-block;
    }

    .btn-success{
        margin-bottom: 15px;
        margin-top: 15px;
        color: black;
    }

</style>


</head>
    <body>

      <nav class="nav-header">
      <div class="nav-user-menu">
      <span class="logout"> <i class="fa fa-circle"></i> <a style="color:#FFF;" href="logout.php">Log Out</a></span>
      </div>
      </nav>

<div class="content-b">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Transaction
      </h1>
      <hr>
    </section>

    <!-- Main content -->
    <div class="container">
    <h3 class="box-title">Transaction List</h3>
        <div class="col-md-10">
          <div class="box box-success">
              
              <div class="box-body">
                  <div style="overflow-x:auto;">
                      <table class="table table-striped" id="myOrder">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Authority</th>
                                  <th>Date</th>
                                  <th>Time</th>
                                  <th>Total Bill</th>
                                  <?php if($_SESSION['role']=="admin"){
                                      echo "<th>Remove</th>";
                                  } ?>

                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              $no = 1;
                              $sql="SELECT * FROM invoice ORDER BY invoice_id DESC";
                              $result = mysqli_query($conn, $sql);


                              while($row = mysqli_fetch_assoc($result)){
                              ?>
                                  <tr>
                                  <td><?php echo $no++ ; ?></td>
                                  <td class="text-uppercase"><?php echo $row['cashier_name']; ?></td>
                                  <td><?php echo $row['order_date']; ?></td>
                                  <td><?php echo $row['time_order']; ?></td>
                                  <td>BDT. <?php echo number_format($row['total']); ?></td>
                                  <td>
                                      <?php if($_SESSION['role']=="admin"){ ?>
                                      <a href="transaction_del.php?id=<?php echo $row['invoice_id']; ?>" onclick="return confirm('Delete Transaction?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                      <?php } ?>

                                  </td>
                                  </tr>
                              <?php
                              }
                              ?>
                          </tbody>
                      </table>
                  </div>

              </div>

          </div>
        </div>
        <div class="box-header with-border">
                  <a href="create_order.php" class="btn btn-success btn-sm ">Add Transaction</a>
              </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





  <script src="js/jquery.js" ></script>
  <script src="js/script.js" ></script>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <script src="js/bootstrap.min.js" ></script>
    </body>
</html>
