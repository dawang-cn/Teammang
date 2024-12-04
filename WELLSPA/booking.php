<?php
session_start();
include 'setup.php'; 
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to book an appointment.");
}

$user_id = $_SESSION['user_id'];  
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
    <title>Booking Page</title>
</head>
<body>
    <h1>Book an Appointment</h1>
    <form action="confirmation.php" method="POST">
        <!-- Step 1: Select Service and Therapist -->
        <h2>Step 1: Select Service and Therapist</h2>

        <!-- Service Selection -->
        <label for="service_id">Select Service:</label>
        <select name="service_id" required>
            <?php foreach ($services as $service) { ?>
                <option value="<?php echo $service['service_id']; ?>"><?php echo $service['service_name']; ?> - $<?php echo $service['price']; ?></option>
            <?php } ?>
        </select>

        <br><br>

        <!-- Therapist Selection -->
        <label for="therapist_id">Select Therapist:</label>
        <select name="therapist_id" required>
            <?php foreach ($therapists as $therapist) { ?>
                <option value="<?php echo $therapist['user_id']; ?>"><?php echo $therapist['full_name']; ?></option>
            <?php } ?>
        </select>

        <br><br>

        <!-- Step 2: Choose Date and Time -->
        <h2>Step 2: Choose Date and Time</h2>

        <!-- Date Picker -->
        <label for="appointment_date">Select Date:</label>
        <input type="date" name="appointment_date" required>

        <br><br>

        <!-- Time Selection (Dropdown) -->
        <label for="start_time">Select Time:</label>
        <select name="start_time" required>
            <?php foreach ($time_slots as $time_slot) { ?>
                <option value="<?php echo $time_slot; ?>"><?php echo $time_slot; ?></option>
            <?php } ?>
        </select>

        <br><br>

        <!-- Step 3: Confirmation and Payment -->
        <h2>Step 3: Confirmation and Payment</h2>

        <!-- Payment Method -->
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" required>
            <option value="cash">Cash</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
        </select>

        <br><br>

        <!-- Promo Code (Optional) -->
        <label for="promo_code">Promo Code (Optional):</label>
        <input type="text" name="promo_code">

        <br><br>

        <!-- Submit Button -->
        <button type="submit" name="submit">Confirm Appointment</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
