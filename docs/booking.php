<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    $conn = new mysqli("localhost", "root", "", "malookhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $room = $_POST['room'];
    $guests = $_POST['guests'];

    // Save to database
    $stmt = $conn->prepare("INSERT INTO bookings (name, phone, checkin, checkout, room, guests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $phone, $checkin, $checkout, $room, $guests);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Your Stay | New Malook Hotel</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
            linear-gradient(rgba(10,15,25,0.75), rgba(10,15,25,0.85)),
            url("hill.jpeg") no-repeat center center/cover;
            font-family: 'Georgia', serif;
            animation: zoomBg 20s infinite alternate;
        }

        .logo {
            position: absolute;
            top: 25px;
            left: 30px;
            width: 110px;
        }

        .booking-box {
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            background: rgba(0, 0, 0, 0.55);
            padding: 50px 60px;
            border-radius: 25px;
            color: white;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
            text-align: left;

            opacity: 0;
            transform: translateY(30px);
            animation: fadeIn 1.5s ease forwards;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 36px;
            letter-spacing: 1px;
        }

        .divider {
            width: 80px;
            border: 1px solid rgba(255,255,255,0.4);
            margin: 20px auto 30px auto;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
        }

        input, select {
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
        }

        input[type="number"] {
            appearance: textfield;
        }

        .book-btn {
            margin-top: 10px;
            padding: 14px;
            background: transparent;
            border: 2px solid white;
            border-radius: 30px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .book-btn:hover {
            background: white;
            color: black;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #cfd8dc;
            text-decoration: none;
            font-size: 14px;
            text-align: center;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomBg {
            from { background-size: 100%; }
            to { background-size: 110%; }
        }
    </style>
</head>

<body>

    <img src="logo.jpeg" alt="Hotel Logo" class="logo">

    <div class="booking-box">
        <h1>Book Your Himalayan Escape</h1>
        <hr class="divider">

        <form method="POST" onsubmit="sendToWhatsApp(event)">
            <div>
                <label>Your Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your name" required>
            </div>

            <div>
                <label>Phone Number</label>
                <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" required>
            </div>

            <div>
                <label>Check-in Date</label>
                <input type="date" name="checkin" id="checkin" required>
            </div>

            <div>
                <label>Check-out Date</label>
                <input type="date" name="checkout" id="checkout" required>
            </div>

            <div>
                <label>Select Room Type</label>
                <select name="room" id="room" required>
                    <option value="">Choose Room</option>
                    <option>Deluxe Room</option>
                    <option>Suite Room</option>
                    <option>Family Room</option>
                    <option>Luxury Suite</option>
                </select>
            </div>

            <div>
                <label>Number of Guests</label>
                <input type="number" name="guests" id="guests" min="1" max="10" placeholder="Enter number of guests" required>
            </div>

            <button type="submit" class="book-btn">
                CONFIRM BOOKING
            </button>
        </form>

        <a href="home.html" class="back-link">
            ← Back to Home
        </a>
    </div>

    <script>
        function sendToWhatsApp(event) {
            event.preventDefault();

            var name = document.getElementById("name").value;
            var phone = document.getElementById("phone").value;
            var checkin = document.getElementById("checkin").value;
            var checkout = document.getElementById("checkout").value;
            var room = document.getElementById("room").value;
            var guests = document.getElementById("guests").value;

            var message =
                "New Booking Request - New Malook Hotel\n\n" +
                "Name: " + name + "\n" +
                "Phone: " + phone + "\n" +
                "Room Type: " + room + "\n" +
                "Check-in: " + checkin + "\n" +
                "Check-out: " + checkout + "\n" +
                "Guests: " + guests;

            // Replace YOURNUMBER with your WhatsApp number
            var whatsappURL = "https://wa.me/919816011318?text=" + encodeURIComponent(message);
            window.open(whatsappURL, "_blank");
        }
    </script>

</body>
</html>
