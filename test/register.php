<?php
// Include the database connection
include 'db.php';

// Start session to manage user login state
session_start();

// Check if the user is already logged in, if so redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit();
}

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    // Sanitize inputs to prevent SQL injection
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password before saving it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $sql = "INSERT INTO users (full_name, email, phone_number, password, role) 
                VALUES ('$full_name', '$email', '$phone_number', '$hashed_password', 'customer')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to login page after successful registration
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
</head>
<body>
    <h1>Register</h1>

    <?php
    // Display error message if any
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form action="register.php" method="POST">
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <input type="submit" name="register" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>

<?php
$conn->close();
?>