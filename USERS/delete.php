<?php
include("setup.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM Users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=User deleted successfully!");
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
