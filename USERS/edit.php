<?php
include("../setup.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($role)) {
        $sql = "UPDATE users SET full_name = '$full_name', email = '$email', phone_number = '$phone_number', role = '$role' WHERE user_id = $id";
        
        if ($conn->query($sql) === TRUE) {
            $message = "User updated successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to update user: " . $conn->error;
            $message_type = "error";
        }
    } else {
        $message = "Please fill in all fields.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url('../images/bg.jpg') no-repeat center center;
            background-size: cover; 
            background-attachment: fixed;
            background-position: center top;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #964B00;
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: black;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #964B00;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #C4A484;
            outline: none;
        }

        input[type="submit"] {
            background: linear-gradient(to top, #c79081 0%, #dfa579 100%);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background: radial-gradient(859px at 10% 20%, rgb(245, 220, 154) 0%, rgb(164, 78, 51) 90%);
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .message.success {
            background-color: #964B00;
            color: white;
        }

        .message.error {
            background-color: #964B00;
            color: white;
        }

        a {
            text-decoration: none;
            color: saddlebrown;
            font-size: 16px;
            text-align: center;
            display: block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?= $message_type; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit.php?id=<?= $user['user_id']; ?>">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?= $user['full_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $user['email']; ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?= $user['phone_number']; ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : ''; ?>>Customer</option>
                <option value="therapist" <?= $user['role'] == 'therapist' ? 'selected' : ''; ?>>Therapist</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>

            <input type="submit" value="Update User">
        </form>

        <a href="index.php">Back to User List</a>
    </div>
</body>
</html>
