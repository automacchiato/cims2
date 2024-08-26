<?php
include '../config/database.php';

// Handle file upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["eqptctrlnum"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["photo"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// If everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["photo"]["eqptctrlnum"])) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$itemtype = $_POST['itemtype'];
$factory = $_POST['factory'];
$eqptctrlnum = $_POST['eqptctrlnum'];
$eqptcat = $_POST['eqptcat'];
$eqptname = $_POST['eqptname'];
$eqptmaker = $_POST['eqptmaker'];
$eqptmodel = $_POST['eqptmodel'];
$eqptsn = $_POST['eqptsn'];
$section = $_POST['section'];
$process = $_POST['process'];
$calibrationdate = $_POST['calibrationdate'];
$calibrationdue = $_POST['calibrationdue'];
$locationprocess = $_POST['locationprocess'];
$currentlocation = $_POST['currentlocation'];
$photo = basename($_FILES["photo"]["eqptctrlnum"]);

$sql = "INSERT INTO items (itemtype, factory, eqptctrlnum, eqptcat, eqptname, eqptmaker, eqptmodel, eqptsn, section, process, calibrationdate, calibrationdue, locationprocess, currentlocation, photo) VALUES ('$itemtype', '$factory', '$eqptctrlnum', '$eqptcat', '$eqptname', '$eqptmaker', '$eqptmodel', '$eqptsn', '$section', '$process', '$calibrationdate', '$calibrationdue', '$locationprocess', '$currentlocation' '$photo')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
