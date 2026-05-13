<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | LeMovie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="navbar__container">
            <a href="index.html" id="navbar__logo">LeMovie</a>
            <ul class="navbar__menu">
                <li class="navbar__item"><a href="index.html" class="navbar__links">HOME</a></li>
            </ul>
        </div>
    </nav>
    
        <div id="admin-page-root" class="admin__section">
        <div class="admin__container">
            
            <?php 
                if(isset($_GET['msg']) && $_GET['msg'] == 'deleted') {
                    echo "<p style='background: #369e62; color: white; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 30px; font-weight: bold; border: 1px solid #10b981;'>Record Deleted Successfully!</p>";
                }
            ?>

            <div class="admin__header">
                <h1>Booking Management</h1>
                <div class="admin__stats">
                    <?php 
                        $conn = new mysqli("localhost", "root", "", "lemovie_db");
                        $res = $conn->query("SELECT COUNT(*) as total FROM bookings");
                        $data = $res->fetch_assoc();
                        echo "Total Orders: <span>" . ($data['total'] ?? 0) . "</span>";
                    ?>
                </div>
            </div>

            <div class="table__wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Seats</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM bookings ORDER BY booking_date DESC");
                        if ($result && $result->num_rows > 0) {
                            $sn = 1;
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>$sn</td>
                                    <td><strong>".$row["customer_name"]."</strong></td>
                                    <td>".$row["email"]."</td>
                                    <td><span class='seat-tag'>".$row["selected_seats"]."</span></td>
                                    <td>RM ".number_format($row["total_price"], 2)."</td>
                                    <td>".date('d M, h:i A', strtotime($row["booking_date"]))."</td>
                                    <td><a href='delete.php?id=".$row["id"]."' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>DELETE</a></td>
                                </tr>";
                                $sn++;
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center; padding:60px; color:#555; font-style:italic;'>No records found in database.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>