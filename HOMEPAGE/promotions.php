<?php
include("../setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $discount_percentage = $_POST['discount_percentage'];

        $sql = "INSERT INTO promotions (title, description, discount_percentage) VALUES ('$title', '$description', '$discount_percentage')";
        if ($conn->query($sql) === TRUE) {
            echo "Promotion created successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM promotions WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Promotion deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM promotions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Promotions CRUD</title>
</head>
<body>
    <h1>Manage Promotions</h1>

    <form method="POST">
        <h2>Create Promotion</h2>
        <input type="text" name="title" placeholder="Promotion Title" required>
        <textarea name="description" placeholder="Promotion Description" required></textarea>
        <input type="number" name="discount_percentage" placeholder="Discount Percentage" required>
        <button type="submit" name="create">Create Promotion</button>
    </form>

    <h2>Existing Promotions</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Discount</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['title']; ?></td>
                <td><?= $row['description']; ?></td>
                <td><?= $row['discount_percentage']; ?>%</td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
