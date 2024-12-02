<?php
include("../setup.php");

// Query to fetch bookings from the database
$bookings = $conn->query("SELECT * FROM bookings");

if (!$bookings) {
    // If the query failed, display an error message
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
</head>
<body>
    <h1>Manage Bookings</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Service</th>
                <th>Therapist</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Loop through the result set and display each booking
            while ($row = $bookings->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['service_id']; ?></td>
                    <td><?= $row['therapist_id']; ?></td>
                    <td><?= $row['date']; ?></td>
                    <td><?= $row['time']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a href="approve_booking.php?id=<?= $row['id']; ?>">Approve</a> |
                        <a href="cancel_booking.php?id=<?= $row['id']; ?>">Cancel</a> |
                        <a href="reschedule_booking.php?id=<?= $row['id']; ?>">Reschedule</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
