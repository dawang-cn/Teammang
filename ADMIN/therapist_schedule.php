<?php
include("../setup.php");

$availability = $conn->query("SELECT * FROM therapist_availability");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Therapist Schedule</title>
</head>
<body>
    <h1>Therapist Schedule</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Therapist</th>
                <th>Date</th>
                <th>Available Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $availability->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['therapist_id']; ?></td>
                    <td><?= $row['date']; ?></td>
                    <td><?= $row['available_time']; ?></td>
                    <td>
                        <a href="edit_availability.php?id=<?= $row['id']; ?>">Edit</a> |
                        <a href="delete_availability.php?id=<?= $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="add_availability.php">Add New Availability</a>
</body>
</html>
