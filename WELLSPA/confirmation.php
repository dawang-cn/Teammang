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

// Calculate the total price
$total_price = $selected_service['price']; // Modify this if there are promo codes or discounts

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
</head>
<body>
    <h1>Appointment Confirmation</h1>
    
    <h2>Your Appointment Details</h2>
    <p><strong>Service:</strong> <?php echo $selected_service['service_name']; ?></p>
    <p><strong>Price:</strong> $<?php echo $selected_service['price']; ?></p>
    
    <p><strong>Therapist:</strong> <?php echo $selected_therapist; ?></p>
    
    <p><strong>Date:</strong> <?php echo $appointment_date; ?></p>
    <p><strong>Time:</strong> <?php echo $start_time; ?></p>
    
    <p><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>
    <p><strong>Promo Code:</strong> <?php echo $promo_code; ?></p>
    
    <p><strong>Total Price:</strong> $<?php echo $total_price; ?></p>

    <form action="home.php" method="POST">
        <button type="submit" name="back" value="confirm">Go Back</button>
    </form>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
