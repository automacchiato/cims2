<?php
include 'config.php';

$id = $_POST['id'];

// Fetch photo filename
$sql = "SELECT photo FROM users WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$photo = $row['photo'];

// Delete record from database
$sql = "DELETE FROM users WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Delete photo file from server if it exists
    if ($photo && file_exists("uploads/$photo")) {
        unlink("uploads/$photo");
    }
    echo "Record deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
