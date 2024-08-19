<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register / CIMS</title>
   <link rel="stylesheet" href="../css/style.css">
   <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
   <div class="container">
   <h2 class="text-center">Register</h2>
   <form action="register.php" method="post">
      <div class="form-group">
         <label for="employeeID">Employee ID:</label>
         <input type="text" id="employeeID" name="employeeID" class="form-control" required>
      </div>
      <div class="form-group">
         <label for="employeeName">Name: </label>
         <input type="text" id="employeeName" name="employeeName" class="form-control" required>         
      </div>
      <div class="form-group">
         <label for="employeePwd">Password: </label>
         <input type="password" id="employeePwd" name="employeePwd" class="form-control" required>
      </div>
      <div>
         <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
      </div>

   </form>
   </div>
   <script src="../js/jquery-3.5.1.min.js"></script>
   <script src="../js/popper.min.js"></script>
   <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   $employeeID = $_POST['employeeID'];
   $employeeName = $_POST['employeeName'];
   $employeePwd = $_POST['employeePwd'];

   //Password hashing (use a strong hashing algorithm like bcrypt)
   $hashed_password = password_hash($employeePwd, PASSWORD_DEFAULT);

   // Insert user into database
   $sql = "INSERT INTO users (employeeID, employeeName, employeePwd) VALUES (?, ?, ?)";
   $stmt = mysqli_prepare($conn, $sql);
   mysqli_stmt_bind_param($stmt, "sss", $employeeID, $employeeName, $hashed_password);

   if (mysqli_stmt_execute($stmt)) {
      echo "Registration successful.";
   } else {
      echo "Registration failed: " . mysqli_error($conn);
   }
   mysqli_stmt_close($stmt);
}
?>

