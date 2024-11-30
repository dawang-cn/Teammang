<?php
include("../setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
      
        $user_id = $_POST['user_id'];
        $service_id = $_POST['service_id'];
        $rating = $_POST['rating'];
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);

        $sql = "INSERT INTO reviews (user_id, service_id, rating, comment) VALUES ('$user_id', '$service_id', '$rating', '$comment')";
        if ($conn->query($sql) === TRUE) {
            echo "Review submitted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews CRUD</title>
</head>
<body>
    <h1>Manage Reviews</h1>

    <form method="POST">
        <h2>Submit a Review</h2>
        <input type="text" name="user_id" placeholder="User ID" required>
        <input type="text" name="service_id" placeholder="Service ID" required>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <textarea name="comment" placeholder="Your Review" required></textarea>
        <button type="submit" name="create">Submit Review</button>
    </form>

    <h2>Existing Reviews</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Service ID</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['user_id']; ?></td>
                <td><?= $row['service_id']; ?></td>
                <td><?= $row['rating']; ?></td>
                <td><?= $row['comment']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
