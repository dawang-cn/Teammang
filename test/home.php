<?php
include 'db.php';

// Check if the user is logged in, if not, redirect to login page
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch upcoming appointments
$upcoming_sql = "SELECT a.appointment_id, s.service_name, a.appointment_date, a.start_time, a.status, u.full_name AS therapist_name
                 FROM appointments a
                 JOIN services s ON a.service_id = s.service_id
                 JOIN users u ON a.therapist_id = u.user_id
                 WHERE a.user_id = $user_id AND a.appointment_date >= CURDATE()
                 ORDER BY a.appointment_date ASC";
$upcoming_result = $conn->query($upcoming_sql);

// Fetch past appointments
$past_sql = "SELECT a.appointment_id, s.service_name, a.appointment_date, a.start_time, a.status, u.full_name AS therapist_name
             FROM appointments a
             JOIN services s ON a.service_id = s.service_id
             JOIN users u ON a.therapist_id = u.user_id
             WHERE a.user_id = $user_id AND a.appointment_date < CURDATE()
             ORDER BY a.appointment_date DESC";
$past_result = $conn->query($past_sql);

// Fetch promotions available to the user
$promotions_sql = "SELECT promo_code, description, discount_percent FROM promotions WHERE NOW() BETWEEN start_date AND end_date";
$promotions_result = $conn->query($promotions_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    
    <!-- Upcoming Appointments -->
    <h2>Upcoming Appointments</h2>
    <div class="appointments-list">
        <?php
        if ($upcoming_result->num_rows > 0) {
            while ($appointment = $upcoming_result->fetch_assoc()) {
                echo "
                <div class='appointment-card'>
                    <p><strong>Service:</strong> {$appointment['service_name']}</p>
                    <p><strong>Date:</strong> {$appointment['appointment_date']} <strong>Time:</strong> {$appointment['start_time']}</p>
                    <p><strong>Therapist:</strong> {$appointment['therapist_name']}</p>
                    <p><strong>Status:</strong> {$appointment['status']}</p>
                    <a href='cancel_appointment.php?appointment_id={$appointment['appointment_id']}'>Cancel</a> | 
                    <a href='reschedule_appointment.php?appointment_id={$appointment['appointment_id']}'>Reschedule</a>
                </div>";
            }
        } else {
            echo "<p>No upcoming appointments.</p>";
        }
        ?>
    </div>

    <!-- Past Appointments -->
    <h2>Past Appointments</h2>
    <div class="appointments-list">
        <?php
        if ($past_result->num_rows > 0) {
            while ($appointment = $past_result->fetch_assoc()) {
                echo "
                <div class='appointment-card'>
                    <p><strong>Service:</strong> {$appointment['service_name']}</p>
                    <p><strong>Date:</strong> {$appointment['appointment_date']} <strong>Time:</strong> {$appointment['start_time']}</p>
                    <p><strong>Therapist:</strong> {$appointment['therapist_name']}</p>
                    <p><strong>Status:</strong> {$appointment['status']}</p>
                    <a href='leave_review.php?appointment_id={$appointment['appointment_id']}'>Leave a Review</a>
                </div>";
            }
        } else {
            echo "<p>No past appointments.</p>";
        }
        ?>
    </div>

    <!-- Account Settings -->
    <h2>Account Settings</h2>
    <div class="account-settings">
        <form action="update_profile.php" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required><br>
            <input type="submit" value="Update Profile">
        </form>

        <form action="update_password.php" method="POST">
            <h3>Change Password</h3>
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required><br>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required><br>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br>
            <input type="submit" value="Change Password">
        </form>
    </div>

    <!-- Promotions and Rewards -->
    <h2>Promotions and Rewards</h2>
    <div class="promotions-list">
        <?php
        if ($promotions_result->num_rows > 0) {
            while ($promotion = $promotions_result->fetch_assoc()) {
                echo "
                <div class='promotion-card'>
                    <p><strong>Promo Code:</strong> {$promotion['promo_code']}</p>
                    <p><strong>Description:</strong> {$promotion['description']}</p>
                    <p><strong>Discount:</strong> {$promotion['discount_percent']}%</p>
                </div>";
            }
        } else {
            echo "<p>No active promotions available.</p>";
        }
        ?>
    </div>

    <!-- Link to Home -->
    <a href="home.php">Back to Home</a>
</body>
</html>

<?php
$conn->close();
?>
