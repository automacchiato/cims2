<?php
   include '../config/database.php';
   session_start();

   //Check if the user is logged in
   if (!isset($_SESSION['id'])) {
      header('Location: login.php');
      exit;
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard / CIMS</title>
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
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">Dashboard<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="items.php">All Items</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
    <span class="navbar-text mr-3 text-light">Hi, <?php echo strtok($_SESSION['employeeName'],""); ?></span>
    <a class="btn btn-outline-light" href="logout.php">Logout</a>
    </form>
  </div>
</nav>

   <div class="container mt-4 container-full-width">
   <h2>Dashboard</h2> <br>
   <h4>Item to be Calibrated this Month</h4>
   <?php
  
   //Retrieve items due for calibration this month
   $current_month = date('Y-m');
   $sql = "SELECT * FROM items WHERE calibrationDue LIKE '$current_month%'";
   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0){
      echo "
      <table class='table table-bordered table-sm'>
         <thead class='thead-light'>
            <tr>
               <th>Process</th>              
               <th>Equipment Control Number</th>
               <th>Item Name</th>
               <th>Calibration Due Date</th>            
            </tr>
         </thead>
         <tbody>";
      while ($row = mysqli_fetch_assoc($result)){
         echo "<tr>
            <td>" . $row['process'] . "</td>
            <td>" . $row['eqptCtrlNum'] . "</td>
            <td>" . $row['eqptName'] . "</td>
            <td>" . $row['calibrationDue'] . "</td>
            </tr>";
         }
         echo "</tbody>
         </table>";
     } else {
         echo "No items due for calibration this month.";
     }

     //Calculate daytoDue for existing item
   $update_sql = "UPDATE items SET daytoDue = ?";
   $stmt = mysqli_prepare($conn, $update_sql);
   mysqli_stmt_bind_param($stmt, "i", $dayToDue);

   while ($row = mysqli_fetch_assoc($result)) {
    $dueDate = new DateTime($row['calibrationDue']);
    $today = new DateTime();
    $interval = $today->diff($dueDate);
    $daytoDue = $interval->days;

    mysqli_stmt_execute($stmt);
   }

   mysqli_stmt_close($stmt);

     ?>

   </div>

   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</body>
</html>