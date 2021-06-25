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
    <link rel="stylesheet" href="css/all.min.css">

<style>
        .btn-success{
        margin-bottom: 15px;
        margin-top: 15px;
        color: black;
    }
    .content-b{
        margin-left: 300px ;
        max-width: 1200px;
        width:1200px;
        display: inline-block;
    }

</style>
</head>

<body>

  <nav class="nav-header">
  <div class="nav-user-menu">
  <span class="logout"> <i class="fa fa-circle"></i> <a style="color:#FFF;" href="logout.php">Log Out</a></span>
  </div>
  </nav>


    <!-- Content Wrapper. Contains page content -->

        <!-- Main content -->
        <div class="row-2"></div>
        <div class="row">
            <div class="box box-success">
              <h3 class="box-title">List of Product</h3>
                <div class="box-body">
                    <div style="overflow-x:auto;">
                        <table class="table table-striped" id="myProduct">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Purchase Price</th>
                                    <th>Sell Price</th>
                                    <th>Stock</th>
                                    <th>Option</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = " SELECT * FROM product";
                                $result = mysqli_query($conn, $sql);



                                while ($row = mysqli_fetch_assoc($result)) {

                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row['pName']; ?></td>
                                        <td><?php echo $row['pCode']; ?></td>
                                        <td>BDT <?php echo number_format($row['purchasePrice']); ?></td>
                                        <td>BDT <?php echo number_format($row['sellPrice']); ?></td>
                                        <td> <?php if ($row['pStock'] == "0") { ?>
                                                <span class="label label-danger"><?php echo $row['pStock']; ?></span>
                                            <?php } elseif ($row['pStock'] <= $row['minStock']) { ?>
                                                <span class="label label-warning"><?php echo $row['pStock']; ?></span>
                                            <?php } else { ?>
                                                <span class="label label-primary"><?php echo $row['pStock']; ?></span>
                                            <?php } ?>

                                        </td>
                                        <td>
                                            <?php if ($_SESSION['role'] == "admin") { ?>


                                                <a href="delete_product.php?id=<?php echo $row['pId']; ?>" class="btn btn-danger btn-sm" name="btn_delete"><i class="fa fa-trash" onclick="return confirm('Confirm removal?')"></i></a><?php
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                    ?>
                                            <a href="view_product.php?id=<?php echo $row['pId']; ?>" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
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
        <div class="row">
          <a href="add_product.php" class="btn btn-success btn-sm pull-right">Add Product</a>
        </div>
        <!-- /.content -->
    <!-- /.content-wrapper -->




    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
