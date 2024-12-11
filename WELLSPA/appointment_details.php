<?php
session_start();
include('setup.php');

// Ensure only admin can access this page
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit;
// }

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch booking details based on the booking_id
    $booking_sql = "SELECT * FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($booking_sql);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $booking_result = $stmt->get_result();
    
    if ($booking_result->num_rows > 0) {
        $booking = $booking_result->fetch_assoc();

        // Fetch user details (customer)
        $user_sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($user_sql);
        $stmt->bind_param('i', $booking['user_id']);
        $stmt->execute();
        $user_result = $stmt->get_result();
        $user = $user_result->fetch_assoc();

        // Fetch therapist details
        $therapist_sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($therapist_sql);
        $stmt->bind_param('i', $booking['therapist_id']);
        $stmt->execute();
        $therapist_result = $stmt->get_result();
        $therapist = $therapist_result->fetch_assoc();

        // Fetch service details
        $service_sql = "SELECT * FROM services WHERE id = ?";
        $stmt = $conn->prepare($service_sql);
        $stmt->bind_param('i', $booking['service_id']);
        $stmt->execute();
        $service_result = $stmt->get_result();
        $service = $service_result->fetch_assoc();
    } else {
        die("Booking not found.");
    }
} else {
    die("No booking ID provided.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        /* Include your styles here */
    </style>
</head>
<body>

<div class="container">
    <h1>Booking Details</h1>

    <table>
        <tr>
            <th>Customer</th>
            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
        </tr>
        <tr>
            <th>Service</th>
            <td><?php echo htmlspecialchars($service['name']); ?></td>
        </tr>
        <tr>
            <th>Therapist</th>
            <td><?php echo htmlspecialchars($therapist['full_name']); ?></td>
        </tr>
        <tr>
            <th>Appointment Date</th>
            <td><?php echo htmlspecialchars($booking['appointment_date']); ?></td>
        </tr>
        <tr>
            <th>Appointment Time</th>
            <td><?php echo htmlspecialchars($booking['appointment_time']); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($booking['status']); ?></td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
        </tr>
    </table>

    <!-- Add buttons for actions like approve, cancel, etc. -->
    <div class="actions">
        <button>Approve</button>
        <button>Cancel</button>
        <button>Reschedule</button>
    </div>

    <button onclick="window.history.back()">Go Back</button>
</div>

</body>
</html>
