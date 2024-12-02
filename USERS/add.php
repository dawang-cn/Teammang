<?php
include ("../setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($password) && !empty($role)) {
        $sql = "INSERT INTO Users (full_name, email, phone_number, password, role) 
                VALUES ('$full_name', '$email', '$phone_number', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            $message = "New user added successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to add new user: " . $conn->error;
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
    <title>Add a New User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('../images/bg.jpg');
            background-size: cover;
            background-position: center center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .form-container {
            background-color: rgba(247, 226, 215, 0.9);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            height: 90%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h1 {
            text-align: center;
            color: #9e8c6b;
            font-size: 26px;
            margin-bottom: 10px;
            margin-top: 0px;
        }

        .logo {
            display: block;
            margin: 0 auto 5px;
            width: 100px;
            height: auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 12px;
            background-color: #fafafa;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #e57a7a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d35c5c;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: #e57a7a;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            z-index: 10;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        function hideMessage() {
            setTimeout(function() {
                const messageElement = document.querySelector('.message');
                if (messageElement) {
                    messageElement.style.display = 'none';
                }
            }, 3000);
        }

        window.onload = function() {
            const messageElement = document.querySelector('.message');
            if (messageElement) {
                hideMessage();
            }
        };
    </script>
</head>
<body>
    <div class="form-container">
        <img src="../images/logo.png" alt="Logo" class="logo">
        <h1>Add a New User</h1>

        <?php if (isset($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="add.php">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="therapist">Therapist</option>
                <option value="admin">Admin</option>
            </select><br>

            <input type="submit" value="Add User">
        </form>

        <br>
        <a href="index.php">Back to Users List</a>
    </div>
</body>
</html>