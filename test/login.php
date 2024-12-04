<?php
// Include the database connection
include 'db.php';

// Start session to keep track of user session
session_start();

if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect to the dashboard
    header("Location: user_dashboard.php");
    exit();
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    // Sanitize input to prevent SQL Injection
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user data from the database
    $sql = "SELECT user_id, full_name, email, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if the email exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, store user data in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to the user dashboard
            header("Location: user_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    // Display error message if any
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</body>
</html>

<?php
$conn->close();
?>
