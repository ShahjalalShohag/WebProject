<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
date_default_timezone_set("Asia/Dhaka");
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


$dt1 = date("Y-m-d");
$time = date("h:i:sa");
$expense = 0;

if (isset($_POST['addItem'])) {
  $pCode = $_POST['pCode'];
  (int)$quantity = $_POST['pQuantity'];
  $fetch = "SELECT * FROM product WHERE pCode='$pCode'";
  $f_query = mysqli_query($conn, $fetch);
  $rows = mysqli_fetch_array($f_query);
  $pName = $rows['pName'];
  $pid = $rows['pId'];
  $pCategory = $rows['pCategory'];
  (float)$s_price = $rows['sellPrice'];
  $pStock = $rows['pStock'];
  $pDescription = $rows['pDescription'];
  (float)$amount = $quantity * $s_price;
  if (mysqli_num_rows($f_query) > 0 and $pStock >= $quantity) {

    $insert2 = "INSERT INTO invoice_detail (pId, pCode, pName, qty, price, total, order_date) VALUES ('$pid','$pCode', '$pName', '$quantity', '$s_price', '$amount', '$dt1')";
    $expense = $amount;


    if (mysqli_query($conn, $insert2)) {
      $update = "UPDATE product SET pStock=pStock-'$quantity' WHERE pCode='$pCode'";
      mysqli_query($conn, $update);
    } else {
      echo '<script type="text/javascript">';
      echo 'alert("Error")';
      echo '</script>';
    }
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("Product Error")';
    echo '</script>';
  }
}
if (isset($_POST['delete_item'])) {
  $item_id = $_POST['id'];
  $sq = "SELECT * FROM invoice_detail WHERE id='$item_id'";
  $res_sq = mysqli_query($conn, $sq);
  $quan = mysqli_fetch_array($res_sq);
  $quantity = (int)$quan['qty'];
  $pCode = $quan['pCode'];
  $update = "UPDATE product SET pStock=pStock+'$quantity' WHERE pCode='$pCode'";
  if (mysqli_query($conn, $update)) {
    $del = "DELETE FROM invoice_detail WHERE id='$item_id'";
    mysqli_query($conn, $del);
  }
}

if (isset($_POST['add_invoice'])) {
  $cashier = $_POST['cashier'];
  $gt = $_POST['gt'];
  $insert = "INSERT INTO invoice (cashier_name, order_date, time_order, total) VALUES('$cashier','$dt1','$time','$gt')";
  if (mysqli_query($conn, $insert)) {
    // header('Location:create_order.php');
    $delete="DELETE FROM invoice_detail";
    mysqli_query($conn, $delete);
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("Something Went Wrong")';
    echo '</script>';
  }
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
  <link rel="stylesheet" href="css/dashboard1.css">

  <style type="text/css">
    .content-b {
      margin-left: 300px;
      max-width: 900px;
      width: 900px;
      display: block;
    }

    .table-striped {
      max-width: 1000px;
    }

    tbody {
      background: #17a2b8;
      max-width: 1100px;
    }
  </style>


</head>

<body>

  <nav class="nav-header">
    <div class="nav-user-menu">
      <nav class="nav-header">
        <div class="nav-user-menu">
          <span class="logout"> <i class="fa fa-circle"></i> <a style="color:#FFF;" href="logout.php">Log Out</a></span>
        </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="row">
    <h1>Transaction Invoice</h1>
    <hr><br>
    <div class="col-md-8">
      <form class="form-group" action="" method="post">
        <input type="text" name="pCode" placeholder="Enter Product Code">
        <input type="number" name="pQuantity" placeholder="Quantity">
        <input type="submit" name="addItem" value="Add Item" class="btn btn-success">
      </form>
    </div>
    <br>
    <table class="table table-striped">
      <tr>
        <th style="width:10px;">ID</th>
        <th style="width:10px;">Code</th>
        <th style="width:10px;">Product Name</th>
        <th style="width:10px;">Quantity</th>
        <th style="width:10px;">Price</th>
        <th style="width:10px;">Total</th>
        <th style="width:10px;"></th>
      </tr>
      <?php
      $show_invoice = "SELECT * FROM invoice_detail";
      $show_res = mysqli_query($conn, $show_invoice);
      $grand_total = 0;
      if (mysqli_num_rows($show_res) > 0) {
        while ($ans = mysqli_fetch_array($show_res)) {
          echo '<tr>';
          echo '<td>' . $ans['id'] . '</td>';
          echo '<td>' . $ans['pCode'] . '</td>';
          echo '<td>' . $ans['pName'] . '</td>';
          echo '<td>' . $ans['qty'] . '</td>';
          echo '<td>' . $ans['price'] . '</td>';
          echo '<td>' . $ans['total'] . '</td>';
          echo '<td>
                <form action="" method="post">
                <input type="hidden" value="' . $ans['id'] . '" name="id">
                <input type="submit" name="delete_item" class="btn btn-danger" value="Remove">
                </form></td>';
          echo '</tr>';
          $j = $ans['total'];
          $grand_total = $grand_total + (float)$j;
        }
      }
      ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td> <b>Grand Total: </b> <?php echo $grand_total; ?></td>
        <td></td>
      </tr>
    </table>
    <form class="form-group" action="" method="post">
      <input type="hidden" name="cashier" value="<?php echo $_SESSION['username']; ?>">
      <input type="hidden" name="gt" value="<?php echo $grand_total; ?>">
      <input type="submit" name="add_invoice" class="btn btn-primary" value="Add Invoice" onclick="return confirm('Proceed Transaction?')">
    </form>
  </div>


  <script src="js/jquery.js"></script>
  <script src="js/script.js"></script>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>