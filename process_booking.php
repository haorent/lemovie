<?php
$conn = new mysqli("localhost", "root", "", "lemovie_db");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $seatIDs = mysqli_real_escape_string($conn, $_POST['seatIDs']);
    $seatsCount = (int)$_POST['seatCount'];
    $total = (float)$_POST['totalPrice'];

    $sql = "INSERT INTO bookings (customer_name, email, selected_seats, seats_reserved, total_price) 
            VALUES ('$name', '$email', '$seatIDs', '$seatsCount', '$total')";

    if ($conn->query($sql) === TRUE) {
        echo "<body style='background-color:#0b0b0b; color:white; font-family:sans-serif; text-align:center; padding-top:100px;'>";
        echo "<div style='max-width:500px; margin:auto; border: 1px solid #369e62; padding:40px; border-radius:12px; background:#1a1a1a;'>";
        echo "<h1 style='color:#369e62;'>BOOKING SUCCESSFUL!</h1>";
        echo "<p>Thank you, <b>$name</b>.</p>";
        echo "<p>Your Seats: <span style='color:#369e62;'>$seatIDs</span></p>";
        echo "<p>Total Amount: <b>RM $total</b></p>";
        echo "<br><a href='index.html' style='color:#fff; text-decoration:none; border:1px solid #444; padding:10px 20px; border-radius:5px; display:inline-block;'>Return Home</a>";
        echo "</div></body>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>