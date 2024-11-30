<?php
include("../setup.php");

$payments = $conn->query("SELECT * FROM payments");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments and Reports</title>
</head>
<body>
    <h1>Payments and Reports</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Booking ID</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $payments->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['booking_id']; ?></td>
                    <td><?= $row['amount']; ?></td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a href="refund_payment.php?id=<?= $row['id']; ?>">Refund</a> |
                        <a href="view_report.php?id=<?= $row['id']; ?>">View Report</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
