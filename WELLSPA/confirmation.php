<?php
session_start();
include('setup.php');

// Ensure the user is logged in before proceeding
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book an appointment.");
}

// Retrieve POST data if available
$service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;
$therapist_id = isset($_POST['therapist_id']) ? $_POST['therapist_id'] : null;
$appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : null;
$start_time = isset($_POST['start_time']) ? $_POST['start_time'] : null;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : null;
$promo_code = isset($_POST['promo_code']) ? $_POST['promo_code'] : null;

// Fetch services, therapists, and time slots (if needed)
$services = [
    ['service_id' => 1, 'service_name' => 'Facial Massage', 'price' => 50],
    ['service_id' => 2, 'service_name' => 'Full Body Massage', 'price' => 100],
    ['service_id' => 3, 'service_name' => 'Manicure and Pedicure', 'price' => 40],
    ['service_id' => 4, 'service_name' => 'Hair Treatments', 'price' => 80]
];
$therapists = [
    ['user_id' => 1, 'full_name' => 'Therapist 1'],
    ['user_id' => 2, 'full_name' => 'Therapist 2'],
    ['user_id' => 3, 'full_name' => 'Therapist 3']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f4e1d2, #d7ccc8);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h1 {
            text-align: center;
            color: #5D4037;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            font-size: 1.1rem;
        }
        th {
            background-color: #964B00;
            color: white;
            font-weight: bold;
        }
        td {
            background-color: #f5f5f5;
        }
        button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #964B00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #7c3600;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h1 {
                font-size: 1.8rem;
            }
            button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Appointment Confirmation</h1>
        
        <table>
            <tr>
                <th>Service</th>
                <td><?php
                    $service_name = '';
                    $service_price = '';
                    foreach ($services as $service) {
                        if ($service['service_id'] == $service_id) {
                            $service_name = $service['service_name'];
                            $service_price = $service['price'];
                            break;
                        }
                    }
                    echo htmlspecialchars($service_name) . " - $" . htmlspecialchars($service_price);
                    ?>
                </td>
            </tr>
            <tr>
                <th>Therapist</th>
                <td><?php
                    $therapist_name = '';
                    foreach ($therapists as $therapist) {
                        if ($therapist['user_id'] == $therapist_id) {
                            $therapist_name = $therapist['full_name'];
                            break;
                        }
                    }
                    echo htmlspecialchars($therapist_name);
                    ?>
                </td>
            </tr>
            <tr>
                <th>Appointment Date</th>
                <td><?php echo htmlspecialchars($appointment_date); ?></td>
            </tr>
            <tr>
                <th>Start Time</th>
                <td><?php echo htmlspecialchars($start_time); ?></td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td><?php echo htmlspecialchars($payment_method); ?></td>
            </tr>
            <tr>
                <th>Promo Code</th>
                <td><?php echo htmlspecialchars($promo_code); ?></td>
            </tr>
        </table>

        <button onclick="window.history.back()">Go Back</button>
    </div>
</body>
</html>
