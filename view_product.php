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
        margin-left:200px ;

        display: inline-block;
        max-height: 500px;
    }
    .box-footer{
      margin-left: 100px;
      margin-bottom: 60px;
      float: right;
    }

  </style>


</head>
    <body>
      <nav class="nav-header">
      <div class="nav-user-menu">
      <span class="logout"> <i class="fa fa-circle"></i> <a style="color:#FFF;" href="logout.php">Log Out</a></span>
      </div>
      </nav>

<!---Product Details--->



    <!-- Main content -->
    <div class="row">
        <div class="box box-success">

              <?php
                $id = $_GET['id'];


                $sql=" SELECT * FROM product WHERE pId='$id' ";
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_assoc($result)){

                    ?>


                  <ul class="list-group" style="width:500px">
                    <center><p class="list-group-item list-group-item-success">Product Details</p></center>
                    <li class="list-group-item"> <b>Product Code</b>     <span class="label badge pull-right"><?php echo $row['pCode']; ?></span></li>
                    <li class="list-group-item"><b>Product Name</b>    <span class="label label-info pull-right"><?php echo $row['pName']; ?></span></li>
                    <li class="list-group-item"><b>Product Category</b>        <span class="label label-primary pull-right"><?php echo $row['pCategory']; ?></span></li>
                    <li class="list-group-item"><b>Pruchase price</b>  <span class="label label-warning pull-right">BDT. <?php echo number_format($row['purchasePrice']); ?></span></li>
                    <li class="list-group-item"><b>Sell Price</b>     <span class="label label-warning pull-right">BDT. <?php echo $row['sellPrice']; ?></span></li>
                    <li class="list-group-item"><b>Profit</b>           <span class="label label-success pull-right">BDT. <?php echo number_format(($row['sellPrice'] - $row['purchasePrice'])); ?></span></li>
                    <li class="list-group-item"><b>Stock</b>          <span class="label label-default pull-right"><?php echo $row['pStock']; ?></span></li>
                    <li class="list-group-item"><b>Minimum Stock </b>   <span class="label label-default pull-right"><?php echo $row['minStock']; ?></span></li>
                    <li class="list-group-item"><b>Short Description</b>  <span class="label label-default pull-right"><?php echo $row['pDescription'] ?></span></li>
                  </ul>

              <?php
                }
              ?>
            <div class="box-footer">
                <a href="product.php" class="btn btn-warning">Back</a>
            </div>

        </div>


    </div>
    <!-- /.content -->

  <!-- /.content-wrapper -->


  <script src="js/jquery.js" ></script>
  <script src="js/script.js" ></script>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <script src="js/bootstrap.min.js" ></script>
    </body>
</html>
