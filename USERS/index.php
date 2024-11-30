<?php
include("../setup.php");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../images/bg.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            background-position: center top;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 20px;
            color: #964B00;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #964B00;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .actions a {
            padding: 10px 15px;
            background: linear-gradient(to top, #c79081 0%, #dfa579 100%);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .actions a.delete {
            background-color: #dc3545;
        }

        .actions a:hover {
            background: radial-gradient(859px at 10% 20%, rgb(245, 220, 154) 0%, rgb(164, 78, 51) 90%);
        }

        .add-user {
            text-align: center;
        }

        .add-user a {
            padding: 12px 20px;
            background: linear-gradient(to top, #c79081 0%, #dfa579 100%);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .add-user a:hover {
            background: radial-gradient(859px at 10% 20%, rgb(245, 220, 154) 0%, rgb(164, 78, 51) 90%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['full_name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['phone_number']; ?></td>
                        <td><?= $row['role']; ?></td>
                        <td class="actions">
                            <a href="edit.php?id=<?= $row['user_id']; ?>">Edit</a>
                            <a href="delete.php?id=<?= $row['user_id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="add-user">
            <a href="add.php">Add New User</a>
        </div>
    </div>
</body>
</html>