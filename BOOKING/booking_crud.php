<?php
include("setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    
    $service_id = $_POST['service_id'];
    $therapist_id = $_POST['therapist_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $payment_method = $_POST['payment_method'];
    $promo_code = $_POST['promo_code'];

    $sql = "INSERT INTO bookings (service_id, therapist_id, date, time, payment_method, promo_code) 
            VALUES ('$service_id', '$therapist_id', '$date', '$time', '$payment_method', '$promo_code')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Booking confirmed!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
