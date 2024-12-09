<?php
include 'setup.php'; 
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            display: flex;
        }

        .sidebar {
            width: 20%;
            background-color: #964B00;
            color: #fff;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 0;
            margin: 5px 0;
            text-align: center;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #7a3c00;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .section {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #964B00;
            color: white;
        }

        .btn {
            background-color: #964B00;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #7a3c00;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="#manage-bookings">Manage Bookings</a>
        <a href="#manage-services">Manage Services</a>
        <a href="#therapist-schedule">Therapist Schedule</a>
        <a href="#payments-reports">Payments & Reports</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <!-- Manage Bookings Section -->
        <div id="manage-bookings" class="section">
            <h2>Manage Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Therapist</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT a.*, u.full_name AS user_name, t.full_name AS therapist_name, s.service_name FROM appointments a 
                        JOIN users u ON a.user_id = u.user_id 
                        JOIN users t ON a.therapist_id = t.user_id 
                        JOIN services s ON a.service_id = s.service_id");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['appointment_id']}</td>
                                <td>{$row['user_name']}</td>
                                <td>{$row['therapist_name']}</td>
                                <td>{$row['service_name']}</td>
                                <td>{$row['appointment_date']}</td>
                                <td>{$row['start_time']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <button class='btn'>Approve</button>
                                    <button class='btn'>Cancel</button>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Manage Services Section -->
        <div id="manage-services" class="section">
            <h2>Manage Services</h2>
            <button class="btn">Add New Service</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM services");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['service_id']}</td>
                                <td>{$row['service_name']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['price']}</td>
                                <td>{$row['duration']} mins</td>
                                <td>
                                    <button class='btn'>Edit</button>
                                    <button class='btn'>Delete</button>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Therapist Schedule Section -->
        <div id="therapist-schedule" class="section">
            <h2>Therapist Schedule</h2>
            <button class="btn">Add Availability</button>
        </div>

        <!-- Payments and Reports Section -->
        <div id="payments-reports" class="section">
            <h2>Payments & Reports</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment ID</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM payments");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['payment_id']}</td>
                                <td>{$row['appointment_id']}</td>
                                <td>{$row['amount']}</td>
                                <td>{$row['payment_method']}</td>
                                <td>{$row['payment_status']}</td>
                                <td>{$row['payment_date']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
