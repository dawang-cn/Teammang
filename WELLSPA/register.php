<?php
include 'setup.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit();
}
if (isset($_POST['register'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, email, phone_number, password, role) 
                VALUES ('$full_name', '$email', '$phone_number', '$hashed_password', 'customer')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
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
    </style>
</head>
<body>

    <div class="register-container">
        <img src="../images/logo.png" alt="Logo" class="logo">
        <h1>Register</h1>

        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form action="register.php" method="POST">
            <input type="text" name="full_name" id="full_name" class="form-input" required placeholder="Full Name"><br>
            <input type="email" name="email" id="email" class="form-input" required placeholder="Email"><br>
            <input type="text" name="phone_number" id="phone_number" class="form-input" required placeholder="Phone Number"><br>
            <input type="password" name="password" id="password" class="form-input" required placeholder="Password"><br>
            <input type="password" name="confirm_password" id="confirm_password" class="form-input" required placeholder="Confirm Password"><br>
            <input type="submit" name="register" value="Register" class="form-submit">
        </form>

        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>

</body>
</html>

<?php
$conn->close();
?>
