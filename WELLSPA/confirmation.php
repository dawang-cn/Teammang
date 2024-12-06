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
<<<<<<< HEAD
$promo_code = $_POST['promo_code'] ?? null; // Optional promo code
=======
$promo_code = $_POST['promo_code'] ?? 'None'; 

$services = [
    1 => ['service_name' => 'Facial Massage', 'price' => 50],
    2 => ['service_name' => 'Full Body Massage', 'price' => 100],
    3 => ['service_name' => 'Manicure and Pedicure', 'price' => 40],
    4 => ['service_name' => 'Hair Treatments', 'price' => 80]
];
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a

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

<<<<<<< HEAD
// Calculate final price after discount
$final_price = $service['price'] - ($service['price'] * ($promo_discount / 100));

// Display the confirmation table
=======
$total_price = $selected_service['price'];
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a
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
<<<<<<< HEAD
            background-color: #f7f7f7;
=======
            background: linear-gradient(to bottom, #5D4037, #795548, #D7CCC8);
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a
            margin: 0;
            padding: 0;
        }
        .container {
<<<<<<< HEAD
            max-width: 800px;
=======
            max-width: 600px;
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a
            margin: 50px auto;
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
        }
        h1 {
            text-align: center;
<<<<<<< HEAD
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
=======
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
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Confirmation</h1>
<<<<<<< HEAD
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
=======
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
>>>>>>> 5faebb8ce9a92eaf7b2b499847dad8faf080d06a
    </div>
</body>
</html>
