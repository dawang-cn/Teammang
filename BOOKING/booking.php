<?php
include("../setup.php");


$services = $conn->query("SELECT * FROM services");
$therapists = $conn->query("SELECT * FROM therapists");

$selected_service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$selected_therapist_id = isset($_GET['therapist_id']) ? $_GET['therapist_id'] : '';
$selected_date = isset($_GET['date']) ? $_GET['date'] : '';
$selected_time = isset($_GET['time']) ? $_GET['time'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Page</title>
</head>
<body>
    <h1>Booking Your Appointment</h1>

    <form method="GET" action="booking_page.php">
        <h2>Step 1: Select Service and Therapist</h2>
        <label for="service">Choose Service:</label>
        <select name="service_id" id="service" required>
            <option value="">Select a Service</option>
            <?php while ($row = $services->fetch_assoc()) { ?>
                <option value="<?= $row['id']; ?>" <?= $selected_service_id == $row['id'] ? 'selected' : ''; ?>><?= $row['name']; ?> - $<?= $row['price']; ?></option>
            <?php } ?>
        </select>
        <br><br>
        
        <label for="therapist">Choose Therapist:</label>
        <select name="therapist_id" id="therapist" required>
            <option value="">Select a Therapist</option>
            <?php while ($row = $therapists->fetch_assoc()) { ?>
                <option value="<?= $row['id']; ?>" <?= $selected_therapist_id == $row['id'] ? 'selected' : ''; ?>><?= $row['name']; ?></option>
            <?php } ?>
        </select>
        <br><br>

        <button type="submit">Next Step</button>
    </form>

    <?php if ($selected_service_id && $selected_therapist_id) { ?>
        <h2>Step 2: Choose Date and Time</h2>
        <form method="GET" action="booking_page.php">
            <input type="hidden" name="service_id" value="<?= $selected_service_id; ?>">
            <input type="hidden" name="therapist_id" value="<?= $selected_therapist_id; ?>">
            
            <label for="date">Choose Date:</label>
            <input type="date" name="date" id="date" required value="<?= $selected_date; ?>">
            <br><br>
            <?php
            if ($selected_date) {
                $time_slots = $conn->query("SELECT * FROM time_slots WHERE service_id = $selected_service_id AND therapist_id = $selected_therapist_id AND available_date = '$selected_date'");
                if ($time_slots->num_rows > 0) {
                    echo "<label for='time'>Choose Time:</label><br>";
                    while ($row = $time_slots->fetch_assoc()) {
                        echo "<input type='radio' name='time' value='" . $row['time'] . "' required> " . $row['time'] . "<br>";
                    }
                } else {
                    echo "<p>No available time slots for this date.</p>";
                }
            }
            ?>
            <br><br>

            <button type="submit">Next Step</button>
        </form>
    <?php } ?>
    <?php if ($selected_date && $selected_time) { ?>
        <h2>Step 3: Confirmation and Payment</h2>
        <form method="POST" action="booking_crud.php">
            <input type="hidden" name="service_id" value="<?= $selected_service_id; ?>">
            <input type="hidden" name="therapist_id" value="<?= $selected_therapist_id; ?>">
            <input type="hidden" name="date" value="<?= $selected_date; ?>">
            <input type="hidden" name="time" value="<?= $selected_time; ?>">
            
            <h3>Appointment Summary</h3>
            <p><strong>Service:</strong> <?= $conn->query("SELECT name FROM services WHERE id = $selected_service_id")->fetch_assoc()['name']; ?></p>
            <p><strong>Therapist:</strong> <?= $conn->query("SELECT name FROM therapists WHERE id = $selected_therapist_id")->fetch_assoc()['name']; ?></p>
            <p><strong>Date:</strong> <?= $selected_date; ?></p>
            <p><strong>Time:</strong> <?= $selected_time; ?></p>
            
            <h3>Payment Options</h3>
            <label for="payment_method">Choose Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
            </select>
            <br><br>
            
            <label for="promo_code">Promo Code:</label>
            <input type="text" name="promo_code" id="promo_code">
            <br><br>

            <button type="submit" name="confirm_booking">Confirm Appointment</button>
        </form>
    <?php } ?>
</body>
</html>
