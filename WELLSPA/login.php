<?php
session_start();
include 'setup.php';
if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT user_id, full_name, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];

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

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h1 {
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

    <div class="login-container">
        <img src="../images/logo.png" alt="Logo" class="logo">
        <h1>Login</h1>

        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>

        <form action="login.php" method="POST">
            <input type="email" name="email" id="email" class="form-input" required placeholder="Email"><br>
            <input type="password" name="password" id="password" class="form-input" required placeholder="Password"><br>
            <input type="submit" name="login" value="Login" class="form-submit">
        </form>

        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>

</body>
</html>

<?php
$conn->close();
?>
