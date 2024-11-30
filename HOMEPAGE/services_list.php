<?php
include("setup.php");
$filter_type = isset($_GET['type']) ? $_GET['type'] : '';
$filter_price_min = isset($_GET['price_min']) ? $_GET['price_min'] : 0;
$filter_price_max = isset($_GET['price_max']) ? $_GET['price_max'] : 1000;
$filter_duration_min = isset($_GET['duration_min']) ? $_GET['duration_min'] : 0;
$filter_duration_max = isset($_GET['duration_max']) ? $_GET['duration_max'] : 180;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'popularity'; 
$sql = "SELECT * FROM services WHERE price BETWEEN $filter_price_min AND $filter_price_max AND duration BETWEEN $filter_duration_min AND $filter_duration_max";
if ($filter_type) {
    $sql .= " AND type = '$filter_type'";
}

if ($sort_by == 'price') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort_by == 'duration') {
    $sql .= " ORDER BY duration ASC";
} else {
    $sql .= " ORDER BY popularity DESC";  
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List</title>
    <style>
        /* Add your CSS for styling */
        .service-card {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            width: 200px;
            text-align: center;
        }
        .service-card img {
            width: 100%;
            height: auto;
        }
        .service-list {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <h1>Our Services</h1>

   
    <div>
        <h2>Filter Services</h2>
        <form method="GET" action="service_list.php">
            <div>
                <label>Type:</label>
                <select name="type">
                    <option value="">All Types</option>
                    <option value="massage" <?= $filter_type == 'massage' ? 'selected' : ''; ?>>Massage</option>
                    <option value="facial" <?= $filter_type == 'facial' ? 'selected' : ''; ?>>Facial</option>
                   
                </select>
            </div>
            <div>
                <label>Price Range:</label>
                <input type="number" name="price_min" placeholder="Min Price" value="<?= $filter_price_min; ?>">
                <input type="number" name="price_max" placeholder="Max Price" value="<?= $filter_price_max; ?>">
            </div>
            <div>
                <label>Duration:</label>
                <input type="number" name="duration_min" placeholder="Min Duration" value="<?= $filter_duration_min; ?>">
                <input type="number" name="duration_max" placeholder="Max Duration" value="<?= $filter_duration_max; ?>">
            </div>
            <div>
                <label>Sort By:</label>
                <select name="sort_by">
                    <option value="popularity" <?= $sort_by == 'popularity' ? 'selected' : ''; ?>>Popularity</option>
                    <option value="price" <?= $sort_by == 'price' ? 'selected' : ''; ?>>Price</option>
                    <option value="duration" <?= $sort_by == 'duration' ? 'selected' : ''; ?>>Duration</option>
                </select>
            </div>
            <button type="submit">Apply Filters</button>
        </form>
    </div>

    <!-- Services List -->
    <div class="service-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="service-card">
                <img src="<?= $row['image_url']; ?>" alt="<?= $row['name']; ?>">
                <h3><?= $row['name']; ?></h3>
                <p><strong>Price:</strong> $<?= $row['price']; ?></p>
                <p><strong>Duration:</strong> <?= $row['duration']; ?> mins</p>
                <p><?= substr($row['description'], 0, 100); ?>...</p>
                <a href="booking_page.php?service_id=<?= $row['id']; ?>">Book Now</a>
            </div>
        <?php } ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
