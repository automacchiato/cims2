<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="assets/bootstrap-4.6.1-dist/css/bootstrap.min.css">
    <title>CIMS / Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="employeeID">Staff ID: </label>
            <input type="text" id="employeeID" name="employeeID" required>
        </div>
        <div class="form-group">
            <label for="employeeName">Name: </label>
            <input type="text" id="employeeName" name="employeeName" required>
        </div>
        <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    
</body>
</html>