<?php
include 'setup.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT full_name, email, phone_number FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate current password
    $password_sql = "SELECT password FROM users WHERE user_id = ?";
    $password_stmt = $conn->prepare($password_sql);
    $password_stmt->bind_param("i", $user_id);
    $password_stmt->execute();
    $password_result = $password_stmt->get_result();
    $password_data = $password_result->fetch_assoc();

    if (!password_verify($current_password, $password_data['password'])) {
        echo "<p style='color: red;'>Current password is incorrect.</p>";
    } else if ($new_password !== $confirm_password) {
        echo "<p style='color: red;'>New password and confirm password do not match.</p>";
    } else {
        // Update user details
        $update_sql = "UPDATE users SET full_name = ?, email = ?, phone_number = ?, password = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_stmt->bind_param("ssssi", $full_name, $email, $phone_number, $hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<p style='color: green;'>Profile updated successfully.</p>";
            header("Refresh: 1"); // Refresh to display updated data
        } else {
            echo "<p style='color: red;'>Error updating profile: " . $conn->error . "</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C4A484;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #964B00;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
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
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-submit:hover {
            background-color: #7a3c00;
        }

        a {
            color: #964B00;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Update Profile</h1>
        <form method="POST">
            <input type="text" name="full_name" class="form-input" value="<?php echo htmlspecialchars($user['full_name']); ?>" placeholder="Full Name" required>
            <input type="email" name="email" class="form-input" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email" required>
            <input type="text" name="phone_number" class="form-input" value="<?php echo htmlspecialchars($user['phone_number']); ?>" placeholder="Phone Number" required>
            <input type="password" name="current_password" class="form-input" placeholder="Current Password" required>
            <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="form-input" placeholder="Confirm New Password" required>
            <input type="submit" value="Update Profile" class="form-submit">
        </form>
        <a href="user_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
