<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lemovie_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM bookings WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: admin.php");
    exit();
}

$conn->close();
?>