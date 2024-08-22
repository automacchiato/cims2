<?php
include '../config/database.php';

//Pagination setup
$items_per_page = 8;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

//Fetch total number of items for pagination
$total_query = "SELECT COUNT(*) as total FROM items";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

//Fetch items for the current page
$sql = "SELECT * FROM items LIMIT $offset, $items_per_page";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Item / CIMS</title>
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/bootstrap.min.css">
   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">CIMS v1</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Dashboard</a>
      </li>
      <li class="nav-item active">
      <a class="nav-link" href="items.php">All Items<span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
    <span class="navbar-text mr-3 text-light">Hi, <?php echo strtok($_SESSION['employeeName'],""); ?></span>
    <a class="btn btn-outline-light" href="logout.php">Logout</a>
    </form>
  </div>
</nav>

<div class="container-full-width">
   <h2>All Items</h2> <br>
   <table class="table table-striped table-bordered">
        <thead class="thead-light text-center">
            <tr>
                <th>Item Type</th>
                <th>Factory</th>
                <th>Equipment Control Number</th>
                <th>Category</th>
                <th>Name</th>
                <th>Maker</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Section</th>
                <th>Process</th>
                <th>Calibration Date</th>
                <th>Calibration Due Date</th>
                <th>Day to Expire</th>
                <th>Location (In Process)</th>
                <th>Current Location</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>

   <?php
  
   while ($row = mysqli_fetch_assoc($result)) {

      //Number of days calculation
 
      //Create DateTime object for today's date and the calibration date
      $today = new DateTime();
      $calibrationDateObj = new DateTime($row['calibrationDue']);
 
      //Calculate the difference between the two dates
      $interval = $today->diff($calibrationDateObj);

      // Check if the calibrationDate is in the future and adjust the sign of days
      if ($interval->invert){
         $numberOfDays = -$numberOfDays;
      }

      //Set variable number of days
      $numberOfDays = $interval->days;


      echo "<tr>";
      echo "<td>" . $row['itemType'] . "</td>";
      echo "<td>" . $row['factory'] . "</td>";
      echo "<td>" . $row['eqptCtrlNum'] . "</td>";
      echo "<td>" . $row['eqptCat'] . "</td>";
      echo "<td>" . $row['eqptName'] . "</td>";         
      echo "<td>" . $row['eqptMaker'] . "</td>";    
      echo "<td>" . $row['eqptModel'] . "</td>";
      echo "<td>" . $row['eqptSN'] . "</td>";
      echo "<td>" . $row['section'] . "</td>"; 
      echo "<td>" . $row['process'] . "</td>"; 
      echo "<td>" . $row['calibrationDate'] . "</td>"; 
      echo "<td>" . $row['calibrationDue'] . "</td>"; 
      echo "<td>" . $numberOfDays . "</td>"; 
      echo "<td>" . $row['locationProcess'] . "</td>"; 
      echo "<td>" . $row['currentLocation'] . "</td>"; 
      echo "<td>" . $row['phoyo'] . "</td>"; 

      echo "<td>
         <a href='editItem.php?id=" . $row['id'] ."'>Edit</a>
         <a href='DeleteItem.php?id=" . $row['id'] ."'>Delete</a>         
      </td>";
   }
   //Retrieve items due for calibration this month
   // $current_month = date('Y-m');
   // $sql = "SELECT * FROM items WHERE calibrationDue LIKE '$current_month%'";
   // $result = mysqli_query($conn, $sql);

   // if (mysqli_num_rows($result) > 0){
   //    echo "
   //    <table class='table table-bordered table-sm'>
   //       <thead class='thead-light'>
   //          <tr>
   //             <th>Process</th>              
   //             <th>Equipment Control Number</th>
   //             <th>Item Name</th>
   //             <th>Calibration Due Date</th>            
   //          </tr>
   //       </thead>
   //       <tbody>";
   //    while ($row = mysqli_fetch_assoc($result)){
   //       echo "<tr>
   //          <td>" . $row['process'] . "</td>
   //          <td>" . $row['eqptCtrlNum'] . "</td>
   //          <td>" . $row['eqptName'] . "</td>
   //          <td>" . $row['calibrationDue'] . "</td>
   //          </tr>";
   //       }
   //       echo "</tbody>
   //       </table>";
   //   } else {
   //       echo "No items due for calibration this month.";
   //   }

   //   //Calculate daytoDue for existing item
   // $update_sql = "UPDATE items SET daytoDue = ?";
   // $stmt = mysqli_prepare($conn, $update_sql);
   // mysqli_stmt_bind_param($stmt, "i", $dayToDue);

   // while ($row = mysqli_fetch_assoc($result)) {
   //  $dueDate = new DateTime($row['calibrationDue']);
   //  $today = new DateTime();
   //  $interval = $today->diff($dueDate);
   //  $daytoDue = $interval->days;

   //  mysqli_stmt_execute($stmt);
   // }

   // mysqli_stmt_close($stmt);

     ?>
        </tbody>
   </table>
</div>

   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</body>
</html>