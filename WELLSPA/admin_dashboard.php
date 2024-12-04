<?php
include 'setup.php';

// Check if the user is an admin, if not, redirect to login page
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all bookings
$booking_sql = "SELECT a.appointment_id, u.full_name AS customer_name, s.service_name, a.appointment_date, a.start_time, a.status
                FROM appointments a
                JOIN services s ON a.service_id = s.service_id
                JOIN users u ON a.user_id = u.user_id";
$booking_result = $conn->query($booking_sql);

// Fetch all services
$service_sql = "SELECT * FROM services";
$service_result = $conn->query($service_sql);

// Fetch therapist availability
$availability_sql = "SELECT u.full_name, a.start_time, a.end_time, a.day_of_week
                     FROM availability a
                     JOIN users u ON a.therapist_id = u.user_id";
$availability_result = $conn->query($availability_sql);

// Fetch payment transactions
$payment_sql = "SELECT p.payment_id, p.amount, p.status, p.payment_date, u.full_name AS customer_name
                FROM payments p
                JOIN users u ON p.user_id = u.user_id";
$payment_result = $conn->query($payment_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Basic styling for the dashboard */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
            margin-top: 20px;
        }
        .dashboard-section {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-warning {
            background-color: #ffc107;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Manage Bookings -->
    <div class="dashboard-section">
        <h2>Manage Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($booking = $booking_result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$booking['customer_name']}</td>
                        <td>{$booking['service_name']}</td>
                        <td>{$booking['appointment_date']}</td>
                        <td>{$booking['start_time']}</td>
                        <td>{$booking['status']}</td>
                        <td>
                            <a href='approve_booking.php?appointment_id={$booking['appointment_id']}' class='btn'>Approve</a>
                            <a href='cancel_booking.php?appointment_id={$booking['appointment_id']}' class='btn btn-danger'>Cancel</a>
                            <a href='reschedule_booking.php?appointment_id={$booking['appointment_id']}' class='btn btn-warning'>Reschedule</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Manage Services -->
    <div class="dashboard-section">
        <h2>Manage Services</h2>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($service = $service_result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$service['service_name']}</td>
                        <td>{$service['description']}</td>
                        <td>{$service['price']}</td>
                        <td>{$service['duration']}</td>
                        <td>
                            <a href='edit_service.php?service_id={$service['service_id']}' class='btn'>Edit</a>
                            <a href='delete_service.php?service_id={$service['service_id']}' class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Add New Service</h3>
        <form action="add_service.php" method="POST">
            <label for="service_name">Service Name:</label>
            <input type="text" name="service_name" id="service_name" required><br>
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required><br>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required><br>
            <label for="duration">Duration:</label>
            <input type="text" name="duration" id="duration" required><br>
            <input type="submit" value="Add Service">
        </form>
    </div>

    <!-- Therapist Schedule Management -->
    <div class="dashboard-section">
        <h2>Therapist Schedule Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Therapist</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($availability = $availability_result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$availability['full_name']}</td>
                        <td>{$availability['day_of_week']}</td>
                        <td>{$availability['start_time']}</td>
                        <td>{$availability['end_time']}</td>
                        <td>
                            <a href='edit_availability.php?therapist_id={$availability['therapist_id']}&day={$availability['day_of_week']}' class='btn'>Edit</a>
                            <a href='delete_availability.php?therapist_id={$availability['therapist_id']}&day={$availability['day_of_week']}' class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Add Therapist Availability</h3>
        <form action="add_availability.php" method="POST">
            <label for="therapist_id">Therapist:</label>
            <select name="therapist_id" id="therapist_id" required>
                <?php
                $therapist_sql = "SELECT * FROM users WHERE role = 'therapist'";
                $therapist_result = $conn->query($therapist_sql);
                while ($therapist = $therapist_result->fetch_assoc()) {
                    echo "<option value='{$therapist['user_id']}'>{$therapist['full_name']}</option>";
                }
                ?>
            </select><br>
            <label for="day_of_week">Day:</label>
            <input type="text" name="day_of_week" id="day_of_week" required><br>
            <label for="start_time">Start Time:</label>
            <input type="time" name="start_time" id="start_time" required><br>
            <label for="end_time">End Time:</label>
            <input type="time" name="end_time" id="end_time" required><br>
            <input type="submit" value="Add Availability">
        </form>
    </div>

    <!-- Payment and Reports -->
    <div class="dashboard-section">
        <h2>Payments and Reports</h2>
        
        <!-- Payments Table -->
        <h3>Payments</h3>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($payment = $payment_result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>{$payment['customer_name']}</td>
                        <td>{$payment['amount']}</td>
                        <td>{$payment['status']}</td>
                        <td>{$payment['payment_date']}</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Reports Section -->
        <h3>Reports</h3>
        <!-- Reports (you can integrate visualizations like charts here) -->
        <p>Data visualizations for bookings, earnings, and customer satisfaction will go here.</p>
    </div>
</body>
</html>
