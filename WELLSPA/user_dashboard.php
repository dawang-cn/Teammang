<?php
include 'setup.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:#C4A484;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .dashboard-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            text-align: center;
        }

        .dashboard-container h1 {
            color: #964B00;
        }

        .appointments-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .appointment-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            text-align: left;
        }

        .appointment-card h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .appointment-card p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        .appointment-card a {
            text-decoration: none;
            color: #007bff;
            font-size: 0.9em;
        }

        .account-settings, .promotions-list {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .promotion-card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #C4A484;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-input:focus {
            border-color: #964B00;
            outline: none;
        }

        .form-submit {
            background-color: #964B00;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-submit:hover {
            background-color: #7a3c00;
        }

        a {
            color: #964B00;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome to Your Dashboard</h1>

        <!-- Upcoming Appointments -->
        <h2>Upcoming Appointments</h2>
        <div class="appointments-list">
            <?php
            if ($upcoming_result->num_rows > 0) {
                while ($appointment = $upcoming_result->fetch_assoc()) {
                    echo "
                    <div class='appointment-card'>
                        <h3>{$appointment['service_name']}</h3>
                        <p><strong>Date:</strong> {$appointment['appointment_date']}</p>
                        <p><strong>Time:</strong> {$appointment['start_time']}</p>
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
                        <h3>{$appointment['service_name']}</h3>
                        <p><strong>Date:</strong> {$appointment['appointment_date']}</p>
                        <p><strong>Time:</strong> {$appointment['start_time']}</p>
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
                <input type="text" name="full_name" id="full_name" class="form-input" required><br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-input" required><br>
                <label for="phone_number">Phone Number:</label>
                <input type="number" name="phone_number" id="phone_number" class="form-input" required><br>
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" class="form-input" required><br>
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" class="form-input" required><br>
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-input" required><br>
                <input type="submit" value="Update Profile" class="form-submit">
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
    </div>

</body>
</html>

<?php
$conn->close();
?>
