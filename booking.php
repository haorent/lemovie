<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lemovie_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$occupiedSeats = [];
$res = $conn->query("SELECT selected_seats FROM bookings");
if ($res) {
    while($row = $res->fetch_assoc()){
        if(!empty($row['selected_seats']) && $row['selected_seats'] !== 'None') {
            $seatsInRow = explode(', ', $row['selected_seats']);
            $occupiedSeats = array_merge($occupiedSeats, $seatsInRow);
        }
    }
}

$occupiedSeats = array_unique(array_map('trim', $occupiedSeats));
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <title>Book Tickets - LeMovie</title>
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #0b0b0b;
            color: white;
            margin: 0;
            padding: 0;
        }

        .booking-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            max-width: 1200px;
            margin: 60px auto;
            padding: 20px;
            gap: 60px; 
        }

        .seating-section {
            flex: 1.5;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .screen {
            background-color: #fff;
            height: 50px;
            width: 100%;
            margin-bottom: 50px;
            transform: rotateX(-45deg);
            box-shadow: 0 3px 20px rgba(255, 255, 255, 0.7);
        }

        .cinema-room {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .seat-row {
            display: flex;
            gap: 12px;
        }

        .seat {
            background-color: #333; 
            height: 40px;
            width: 40px;
            border-radius: 5px 5px 0 0; 
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .seat:hover:not(.occupied) {
            transform: scale(1.2);
            background-color: #666;
        }

        .seat.selected {
            background-color: #369e62; 
        }

        .seat.occupied {
            background-color: #fff; 
            cursor: not-allowed;
            opacity: 0.3;
        }

        .checkout-section {
            width: 380px; 
            background-color: #1a1a1a;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.6);
        }

        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .booking-form input {
            padding: 15px;
            background-color: #2b2b2b;
            border: 1px solid #444;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box; 
        }

        .checkout-btn {
            padding: 18px;
            background-color: #369e62; 
            color: white;
            border: none;
            font-weight: 900;
            font-size: 18px;
            cursor: pointer;
            border-radius: 6px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .checkout-btn:hover {
            background-color: #2b7d4e;
        }

        .info-text {
            margin-top: 25px;
            border-top: 1px solid #333;
            padding-top: 15px;
        }

        .info-text span {
            color: #369e62;
            font-weight: bold;
        }

        @media (max-width: 900px) {
            .booking-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    
    <nav class="navbar" style="background-color: #000; padding: 15px 50px; border-bottom: 1px solid #333;">
        <div class="navbar__container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="index.html" id="navbar__logo" style="color: #ffffff; font-size: 28px; font-weight: 900">LeMovie</a>
            <div class="navbar__menu">
                <a href="index.html" class="navbar__links" style="color: white; text-decoration: none; font-weight: bold;">HOME</a>
            </div>
        </div>
    </nav>

    <div class="booking-container">
        
        <div class="seating-section">
            <h2 style="margin-top: 0; letter-spacing: 2px; text-transform: uppercase;">SELECT YOUR SEATS</h2>
            <div class="screen"></div>
            
            <div class="cinema-room">
                <?php foreach(['A', 'B', 'C', 'D'] as $rowLetter): ?>
                    <div class="seat-row">
                        <?php for($i = 1; $i <= 8; $i++): 
                            $id = $rowLetter . $i;
                            $isOccupied = in_array($id, $occupiedSeats);
                        ?>
                            <div class="seat <?php echo $isOccupied ? 'occupied' : ''; ?>" id="<?php echo $id; ?>"></div>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="checkout-section">
            <h2 style="margin-top: 0;">CHECKOUT</h2>
            
            <form action="process_booking.php" method="POST" class="booking-form" id="bookingForm">
                <input type="text" name="fullName" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="text" name="cardNumber" placeholder="Card Number (16 digits)" required>
                
                <div style="display: flex; gap: 10px;">
                    <input type="text" name="expiry" placeholder="MM/YY" required>
                    <input type="text" name="cvv" placeholder="CVV" maxlength="3" required>
                </div>
                
                <input type="hidden" name="seatCount" id="hiddenSeatCount" value="0">
                <input type="hidden" name="totalPrice" id="hiddenTotalPrice" value="0">
                <input type="hidden" name="seatIDs" id="hiddenSeatIDs" value="">

                <button type="submit" class="checkout-btn">CONFIRM BOOKING</button>
            </form>

            <div class="info-text">
                <p>Seats: <span id="seat-list">None</span></p>
                <p>Total: <span id="total-price" style="font-size: 24px;">RM 0</span></p>
            </div>
        </div>
    </div>

    <script>
        const container = document.querySelector('.cinema-room');
        const seatList = document.getElementById('seat-list');
        const totalPriceDisp = document.getElementById('total-price');
        
        const hCount = document.getElementById('hiddenSeatCount');
        const hTotal = document.getElementById('hiddenTotalPrice');
        const hIDs = document.getElementById('hiddenSeatIDs');

        const pricePerTicket = 25; 

        container.addEventListener('click', e => {
            if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
                e.target.classList.toggle('selected');
                const selectedSeats = document.querySelectorAll('.seat.selected');
                const selectedCount = selectedSeats.length;
                const selectedIDs = [...selectedSeats].map(seat => seat.id);
                seatList.innerText = selectedIDs.length > 0 ? selectedIDs.join(', ') : 'None';
                totalPriceDisp.innerText = "RM " + (selectedCount * pricePerTicket);
                hCount.value = selectedCount;
                hTotal.value = selectedCount * pricePerTicket;
                hIDs.value = selectedIDs.join(', '); 
            }
        });
    </script>
</body>
</html>