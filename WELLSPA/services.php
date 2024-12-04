<?php
include 'setup.php';
$filterType = $_GET['type'] ?? '';
$priceRange = $_GET['price_range'] ?? '';
$sortOrder = $_GET['sort'] ?? '';

$sql = "SELECT service_id, service_name, description, duration, price FROM services WHERE 1=1";

if (!empty($filterType)) {
    $sql .= " AND service_name LIKE '%$filterType%'";
}
if (!empty($priceRange)) {
    $range = explode('-', $priceRange);
    $sql .= " AND price BETWEEN $range[0] AND $range[1]";
}
if ($sortOrder === 'price') {
    $sql .= " ORDER BY price ASC";
} elseif ($sortOrder === 'duration') {
    $sql .= " ORDER BY duration ASC";
} else {
    $sql .= " ORDER BY service_name ASC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List</title>
</head>
<body>
    <h1>Our Services</h1>

    <!-- Filters -->
    <form method="GET" action="">
        <label for="type">Service Type:</label>
        <input type="text" name="type" id="type" placeholder="Search service...">
        
        <label for="price_range">Price Range:</label>
        <select name="price_range" id="price_range">
            <option value="">All</option>
            <option value="0-50">0 - 50</option>
            <option value="50-100">50 - 100</option>
            <option value="100-200">100 - 200</option>
        </select>

        <label for="sort">Sort By:</label>
        <select name="sort" id="sort">
            <option value="">Default</option>
            <option value="price">Price</option>
            <option value="duration">Duration</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Service List -->
    <div class="services-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($service = $result->fetch_assoc()) {
                echo "
                <div class='service-card'>
                    <h3>{$service['service_name']}</h3>
                    <p>Description: {$service['description']}</p>
                    <p>Price: \$ {$service['price']}</p>
                    <p>Duration: {$service['duration']} mins</p>
                    <button onclick=\"location.href='booking.php?service_id={$service['service_id']}'\">Book Now</button>
                </div>";
            }
        } else {
            echo "<p>No services available.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
