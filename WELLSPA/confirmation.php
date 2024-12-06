<?php
session_start();
include('setup.php');

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to confirm an appointment.");
}

// Fetch data from the form
$service_id = $_POST['service_id'];
$therapist_id = $_POST['therapist_id'];
$appointment_date = $_POST['appointment_date'];
$start_time = $_POST['start_time'];
$payment_method = $_POST['payment_method'];
$promo_code = $_POST['promo_code'] ?? null; // Optional promo code

// Fetch service details
$service_query = "SELECT * FROM services WHERE service_id = ?";
$stmt = $conn->prepare($service_query);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$service_result = $stmt->get_result();
$service = $service_result->fetch_assoc();

// Fetch therapist details
$therapist_query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($therapist_query);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$therapist_result = $stmt->get_result();
$therapist = $therapist_result->fetch_assoc();

// Handle payment and promo code (optional logic for promo code)
$promo_discount = 0;
if ($promo_code) {
    $promo_query = "SELECT discount_percent FROM promotions WHERE promo_code = ?";
    $stmt = $conn->prepare($promo_query);
    $stmt->bind_param("s", $promo_code);
    $stmt->execute();
    $promo_result = $stmt->get_result();
    if ($promo_result->num_rows > 0) {
        $promo = $promo_result->fetch_assoc();
        $promo_discount = $promo['discount_percent'];
    }
}

// Calculate final price after discount
$final_price = $service['price'] - ($service['price'] * ($promo_discount / 100));

// Display the confirmation table
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
            background-color: #f7f7f7;
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
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Confirmation</h1>
        <table>
            <tr>
                <th>Service</th>
                <td><?= $service['service_name'] ?></td>
            </tr>
            <tr>
                <th>Therapist</th>
                <td><?= $therapist['full_name'] ?></td>
            </tr>
            <tr>
                <th>Appointment Date</th>
                <td><?= $appointment_date ?></td>
            </tr>
            <tr>
                <th>Start Time</th>
                <td><?= $start_time ?></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td><?= ucfirst($payment_method) ?></td>
            </tr>
            <?php if ($promo_code): ?>
                <tr>
                    <th>Promo Code</th>
                    <td><?= htmlspecialchars($promo_code) ?> - <?= $promo_discount ?>% Discount</td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Final Price</th>
                <td>$<?= number_format($final_price, 2) ?></td>
            </tr>
        </table>
        <a href="booking.php" style="display: block; margin-top: 20px; text-align: center; color: #964B00; font-weight: bold;">Back to Booking</a>
    </div>
</body>
</html>
