<?php
include("../setup.php");

$services = $conn->query("SELECT * FROM services");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
</head>
<body>
    <h1>Manage Services</h1>

    <a href="add_service.php">Add New Service</a>

    <table border="1">
        <thead>
            <tr>
                <th>Service ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $services->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td><?= $row['price']; ?></td>
                    <td><?= $row['duration']; ?></td>
                    <td>
                        <a href="edit_service.php?id=<?= $row['id']; ?>">Edit</a> |
                        <a href="delete_service.php?id=<?= $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
