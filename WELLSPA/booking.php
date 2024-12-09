<?php
session_start();
include('setup.php'); 

// Ensure the user is logged in before proceeding
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book an appointment.");
}

$user_id = $_SESSION['user_id'];  

// Services array (can also be fetched from the database)
$services = [
    ['service_id' => 1, 'service_name' => 'Facial Massage', 'price' => 50],
    ['service_id' => 2, 'service_name' => 'Full Body Massage', 'price' => 100],
    ['service_id' => 3, 'service_name' => 'Manicure and Pedicure', 'price' => 40],
    ['service_id' => 4, 'service_name' => 'Hair Treatments', 'price' => 80]
];

// Therapists array (can also be fetched from the database)
$therapists = [
    ['user_id' => 1, 'full_name' => 'Therapist 1'],
    ['user_id' => 2, 'full_name' => 'Therapist 2'],
    ['user_id' => 3, 'full_name' => 'Therapist 3']
];

// Time slots array
$time_slots = [
    '07:00-08:00 AM', '08:00-09:00 AM', '09:00-10:00 AM', '10:00-11:00 AM',
    '11:00-12:00 PM', '12:00-01:00 PM', '01:00-02:00 PM', '02:00-03:00 PM',
    '03:00-04:00 PM', '04:00-05:00 PM'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #5D4037, #795548, #D7CCC8); 
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        h2 {
            color: #555;
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }
        select, input[type="date"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #CCC;
            border-radius: 5px;
        }
        button {
            background-color: #964B00;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #C4A484;
        }
        .step {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book an Appointment</h1>
        <form action="confirmation.php" method="POST">
            <div class="step">
                <h2>Step 1: Select Service and Therapist</h2>
                <label for="service_id">Select Service:</label>
                <select name="service_id" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= htmlspecialchars($service['service_id']) ?>">
                            <?= htmlspecialchars($service['service_name']) ?> - $<?= htmlspecialchars($service['price']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="therapist_id">Select Therapist:</label>
                <select name="therapist_id" required>
                    <?php foreach ($therapists as $therapist): ?>
                        <option value="<?= htmlspecialchars($therapist['user_id']) ?>">
                            <?= htmlspecialchars($therapist['full_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="step">
                <h2>Step 2: Choose Date and Time</h2>
                <label for="appointment_date">Select Date:</label>
                <input type="date" name="appointment_date" required>
                <label for="start_time">Select Time:</label>
                <select name="start_time" required>
                    <?php foreach ($time_slots as $time_slot): ?>
                        <option value="<?= htmlspecialchars($time_slot) ?>">
                            <?= htmlspecialchars($time_slot) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="step">
                <h2>Step 3: Confirmation and Payment</h2>
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" required>
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
                <label for="promo_code">Promo Code (Optional):</label>
                <input type="text" name="promo_code">
            </div>
            <button type="submit" name="submit">Confirm Appointment</button>
        </form>
    </div>
</body>
</html>
