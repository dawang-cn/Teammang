<?php
include 'setup.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $full_name, $email, $phone_number, $hashed_password, $role);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container h1 {
            color: #964B00;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #C4A484;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-input:focus {
            border-color: #964B00;
            outline: none;
        }

        .form-submit {
            background-color: #964B00;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-submit:hover {
            background-color: #7a3c00;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        p {
            color: #777;
        }

        a {
            color: #964B00;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        label.role {
        display: block;
        text-align: left;
        font-weight: bold;
        margin: 15px 0 5px;
        color: #964B00;
        display: flex;
    }

    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #C4A484;
        border-radius: 5px;
        font-size: 16px;
        background-color: #fff;
        color: #333;
        cursor: pointer;
    }

    select:focus {
        border-color: #964B00;
        outline: none;
        background-color: #f9f9f9;
    }

    select option {
        color: #333;
    }
    </style>
</head>
<body>

    <div class="register-container">
        <img src="../images/logo.png" alt="Logo" class="logo">
        <h1>Register</h1>

        <form action="register.php" method="POST">
            <input type="text" name="full_name" id="full_name" class="form-input" required placeholder="Full Name"><br>
            <input type="email" name="email" id="email" class="form-input" required placeholder="Email"><br>
            <input type="text" name="phone_number" id="phone_number" class="form-input" required placeholder="Phone Number"><br>
            <input type="password" name="password" id="password" class="form-input" required placeholder="Password"><br>
            <input type="password" name="confirm_password" id="confirm_password" class="form-input" required placeholder="Confirm Password"><br>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="customer">Customer</option>
                <option value="therapist">Therapist</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" name="register" value="Register" class="form-submit">
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>

</body>
</html>
