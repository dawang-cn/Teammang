<?php
include ("setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!empty($full_name) && !empty($email) && !empty($phone_number) && !empty($password) && !empty($role)) {
        $email_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";

        if ($result->num_rows > 0) {
            $message = "Email already exists. Please use a different email address.";
            $message_type = "error";
        } else {
           
            $sql = "INSERT INTO users (full_name, email, phone_number, password, role) 
                    VALUES ('$full_name', '$email', '$phone_number', '$password', '$role')";

            if ($conn->query($sql) === TRUE) {
                $message = "New user added successfully!";
                $message_type = "success";
            } else {
                $message = "Failed to add new user: " . $conn->error;
                $message_type = "error";
            }
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
       
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #00aaff, #0077cc); 
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0077cc;
            font-size: 32px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        form {
            margin: 0;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #0077cc;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #00aaff;
            outline: none;
        }


        input[type="submit"] {
            background: linear-gradient(to right, #00aaff, #0077cc);
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
            background: linear-gradient(to right, #0077cc, #00aaff);
        }

        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .message.success {
            background-color: #4caf50;
            color: white;
        }

        .message.error {
            background-color: #f44336;
            color: white;
        }

        a {
            text-decoration: none;
            color: #0077cc;
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
        <h1>Add a New User</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?= $message_type; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="add.php">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="therapist">Therapist</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" value="Add User">
        </form>

        <a href="index.php">Back to Users List</a>
    </div>
</body>
</html>
