<?php
session_start();
include 'setup.php';

// Ensure only admin can access this page
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit;
// }

// Fetch bookings
$bookings_sql = "SELECT * FROM appointments";
$bookings_result = $conn->query($bookings_sql);

// Fetch services
$services_sql = "SELECT * FROM services";
$services_result = $conn->query($services_sql);

// Fetch payments
$payments_sql = "SELECT * FROM payments";
$payments_result = $conn->query($payments_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            width: 90%;
            margin: 20px auto;
        }

        h1 {
            color: #964B00;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #964B00;
            color: #fff;
        }

        .actions button {
            background-color: #964B00;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .actions button:hover {
            background-color: #7a3c00;
        }

        .add-service-form {
            margin: 20px 0;
        }

        .add-service-form input, .add-service-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-service-form button {
            background-color: #964B00;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
        }

        .add-service-form button:hover {
            background-color: #7a3c00;
        }

        .logout {
            text-align: right;
        }

        .logout a {
            text-decoration: none;
            color: #964B00;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h1>Admin Dashboard</h1>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <!-- Manage Bookings -->
<section>
    <h2>Manage Bookings</h2>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Customer</th>
            <th>Therapist</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $bookings_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['therapist_id']; ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td><?php echo $row['appointment_time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td class="actions">
                    <!-- Add a button to view the details -->
                    <a href="appointment_details.php?booking_id=<?php echo $row['id']; ?>"><button>View Details</button></a>
                    <button>Approve</button>
                    <button>Cancel</button>
                    <button>Reschedule</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</section>


    <!-- Add New Service -->
    <section class="add-service-form">
        <h2>Add New Service</h2>
        <form action="add_service.php" method="POST">
            <input type="text" name="name" required placeholder="Service Name">
            <textarea name="description" required placeholder="Service Description"></textarea>
            <input type="number" name="price" required placeholder="Service Price">
            <input type="text" name="duration" required placeholder="Service Duration (e.g., 1 hour)">
            <button type="submit">Add Service</button>
        </form>
    </section>

    <!-- Manage Payments -->
    <section>
        <h2>Payments</h2>
        <table>
            <tr>
                <th>Payment ID</th>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>

            <?php while ($row = $payments_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['appointment_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                
            <?php endwhile; ?>
        </table>
    </section>
</div>

</body>
</html>
