<?php
include("setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
  
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $appointment_date = $_POST['appointment_date'];

        $sql = "INSERT INTO appointments (user_id, service_id, appointment_date) VALUES ('$user_id', '$service_id', '$appointment_date')";
        if ($conn->query($sql) === TRUE) {
            echo "Appointment created successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $sql = "UPDATE appointments SET status='$status' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Appointment updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments CRUD</title>
</head>
<body>
    <h1>Manage Appointments</h1>

    <form method="POST">
        <h2>Create Appointment</h2>
        <input type="text" name="user_id" placeholder="User ID" required>
        <input type="text" name="service_id" placeholder="Service ID" required>
        <input type="datetime-local" name="appointment_date" required>
        <button type="submit" name="create">Create Appointment</button>
    </form>

    <h2>Existing Appointments</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Service ID</th>
            <th>Appointment Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['service_id']; ?></td>
                <td><?= $row['appointment_date']; ?></td>
                <td><?= $row['status']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <select name="status">
                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="confirmed" <?= $row['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="completed" <?= $row['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="canceled" <?= $row['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                        </select>
                        <button type="submit" name="update">Update Status</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
