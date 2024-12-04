<?php
session_start();
include('setup.php'); 
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}

$service_id = $_POST['service_id'];
$therapist_id = $_POST['therapist_id'];
$appointment_date = $_POST['appointment_date'];
$start_time = $_POST['start_time'];
$payment_method = $_POST['payment_method'];
$promo_code = $_POST['promo_code'] ?? 'None'; 

$services = [
    1 => ['service_name' => 'Facial Massage', 'price' => 50],
    2 => ['service_name' => 'Full Body Massage', 'price' => 100],
    3 => ['service_name' => 'Manicure and Pedicure', 'price' => 40],
    4 => ['service_name' => 'Hair Treatments', 'price' => 80]
];

$therapists = [
    1 => 'Therapist 1',
    2 => 'Therapist 2',
    3 => 'Therapist 3'
];

$selected_service = $services[$service_id] ?? null;
$selected_therapist = $therapists[$therapist_id] ?? null;

if (!$selected_service || !$selected_therapist) {
    die("Invalid service or therapist.");
}

$total_price = $selected_service['price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #5D4037, #795548, #D7CCC8);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
        }
        h1 {
            text-align: center;
            color: #964B00;
            margin-bottom: 20px;
        }
        p {
            font-size: 1em;
            margin: 10px 0;
        }
        strong {
            color: #555;
        }
        button {
            background-color: #964B00;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
        }
        button:hover {
            background-color: #C4A484;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Confirmation</h1>
        <h2>Your Appointment Details</h2>
        <p><strong>Service:</strong> <?= $selected_service['service_name']; ?></p>
        <p><strong>Price:</strong> $<?= $selected_service['price']; ?></p>
        <p><strong>Therapist:</strong> <?= $selected_therapist; ?></p>
        <p><strong>Date:</strong> <?= $appointment_date; ?></p>
        <p><strong>Time:</strong> <?= $start_time; ?></p>
        <p><strong>Payment Method:</strong> <?= ucfirst($payment_method); ?></p>
        <p><strong>Promo Code:</strong> <?= $promo_code; ?></p>
        <p><strong>Total Price:</strong> $<?= $total_price; ?></p>
        <form action="home.php" method="POST">
            <button type="submit" name="back" value="confirm">Go Back</button>
        </form>
    </div>
</body>
</html>
