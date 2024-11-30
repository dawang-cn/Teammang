<?php
include("../setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_POST['user_id'];
        $therapist_id = $_POST['therapist_id'];
        $service_id = $_POST['service_id'];
        $appointment_date = $_POST['appointment_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        
        $sql = "INSERT INTO appointments (user_id, therapist_id, service_id, appointment_date, start_time, end_time, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'pending')";

        if ($stmt = $conn->prepare($sql)) {
          $stmt->bind_param("iiisss", $user_id, $therapist_id, $service_id, $appointment_date, $start_time, $end_time);
          if ($stmt->execute()) {
              echo "Appointment booked successfully!";
          } else {
              echo "Error booking appointment: " . $stmt->error;
          }
          $stmt->close();
        }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointments CRUD</title>
</head>
<body>
    <h1>Manage Appointments</h1>

    <form method="post" action="create_appointment.php">
    User ID: <input type="text" name="user_id" required><br>
    Therapist ID: <input type="text" name="therapist_id" required><br>
    Service ID: <input type="text" name="service_id" required><br>
    Appointment Date: <input type="date" name="appointment_date" required><br>
    Start Time: <input type="time" name="start_time" required><br>
    End Time: <input type="time" name="end_time" required><br>
    <input type="submit" value="Book Appointment">
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
