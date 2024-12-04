<?php
session_start();
include 'db.php';  // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your appointment.");
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID

// Retrieve the POST data from the form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_appointment'])) {
    // Get the POST data sent from the confirmation page
    $service_id = $_POST['service_id'];
    $therapist_id = $_POST['therapist_id'];
    $appointment_date = $_POST['appointment_date'];
    $start_time = $_POST['start_time'];
    $payment_method = $_POST['payment_method'];
    $promo_code = $_POST['promo_code'];
    
    // Static services and therapists list (you can pull these from a database instead)
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

    // Find the selected service and therapist
    $selected_service = null;
    $selected_therapist = null;

    foreach ($services as $service) {
        if ($service['service_id'] == $service_id) {
            $selected_service = $service;
            break;
        }
    }

    foreach ($therapists as $therapist) {
        if ($therapist['user_id'] == $therapist_id) {
            $selected_therapist = $therapist;
            break;
        }
    }

    // Process the booking (store in the database if necessary)

    // Insert the booking into the database
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_id, therapist_id, appointment_date, start_time, payment_method, promo_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissss", $user_id, $service_id, $therapist_id, $appointment_date, $start_time, $payment_method, $promo_code);
    $stmt->execute();
    $stmt->close();
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmed</h1>

    <h2>Appointment Details</h2>
    <p><strong>Service:</strong> <?php echo $selected_service['service_name']; ?> - $<?php echo $selected_service['price']; ?></p>
    <p><strong>Therapist:</strong> <?php echo $selected_therapist['full_name']; ?></p>
    <p><strong>Date:</strong> <?php echo $appointment_date; ?></p>
    <p><strong>Time:</strong> <?php echo $start_time; ?></p>
    <p><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>

    <?php if (!empty($promo_code)) { ?>
        <p><strong>Promo Code:</strong> <?php echo $promo_code; ?></p>
    <?php } ?>

    <h3>Your appointment has been successfully booked! You will receive a confirmation email shortly.</h3>

    <a href="user_dashboard.php">Go to Dashboard</a><br><br>
    
    <!-- Link to go back to homepage -->
    <a href="home.php">Go to Homepage</a>
</body>
</html>

<?php
$conn->close();
?>
