<?php
include '../config/database.php';
session_start();

$showAlert = false;
$errorMessage = "Invalid username or password.";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   $employeeID = $_POST['employeeID'];
   $employeePwd = $_POST['employeePwd'];

   //Retrieve user from database
   $sql = "SELECT * FROM users WHERE employeeID = ?";
   $stmt = mysqli_prepare($conn, $sql);
   mysqli_stmt_bind_param($stmt, "s", $employeeID);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   $user = mysqli_fetch_assoc($result);
   mysqli_stmt_close($stmt);

   if ($user && password_verify($employeePwd, $user['employeePwd'])){
      $_SESSION['id'] = $user['id'];
      $_SESSION['employeeName'] = $user['employeeName'];      
      $_SESSION['employeeRole'] = $user['employeeRole'];      
      header('Location: dashboard.php');
      exit;
   } else {
      $showAlert = true;
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login / CIMS</title>
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <span class="navbar-brand mb-0 h1">Calibration Item Management System</span>
</nav>

   <div class="container mt-5 container-full-width">
      <h2 class="text-center">Login</h2>
      <form action="login.php" method="post">
         <div class="form-group">
            <label for="employeeID">Employee ID:</label>
            <input type="text" id="employeeID" name="employeeID" class="form-control" required>
         </div>
         <div class="form-group">
            <label for="employeePwd">Password: </label>
            <input type="password" id="employeePwd" name="employeePwd" class="form-control" required>
         </div>
         <button type="submit" class="btn btn-success btn-lg btn-block">Login</button>
      </form> <br>

      <?php if ($showAlert): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
   <?php endif; ?>

   </div>

   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</body>
</html>

