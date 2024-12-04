<?php
include 'setup.php';

// Services array
$services = [
    ['service_id' => 1, 'service_name' => 'Facial Massage', 'price' => 50],
    ['service_id' => 2, 'service_name' => 'Full Body Massage', 'price' => 100],
    ['service_id' => 3, 'service_name' => 'Manicure and Pedicure', 'price' => 40],
    ['service_id' => 4, 'service_name' => 'Hair Treatments', 'price' => 80],
];

// Filters
$serviceType = isset($_GET['service_type']) ? $_GET['service_type'] : '';
$priceRange = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'popularity';

// Build SQL query
$sql = "SELECT * FROM services WHERE 1=1";

if ($serviceType) {
    $sql .= " AND service_id = '$serviceType'";
}

if ($priceRange) {
    $priceLimits = explode('-', $priceRange);
    $sql .= " AND price BETWEEN {$priceLimits[0]} AND {$priceLimits[1]}";
}

switch ($sortBy) {
    case 'price':
        $sql .= " ORDER BY price ASC";
        break;
    case 'popularity':
    default:
        $sql .= " ORDER BY service_id ASC";
        break;
}

// Execute query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5DC; /* Beige background */
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #964B00; /* Warm brown */
            margin-bottom: 20px;
        }
        .filters {
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .filters select, .filters button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #C4A484; /* Soft brown */
            border-radius: 5px;
        }
        .filters button {
            background-color: #964B00;
            color: white;
            cursor: pointer;
        }
        .filters button:hover {
            background-color: #C4A484;
        }
        .service-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .service-card {
            width: 280px;
            background-color: #FFFFFF; /* White for contrast */
            border: 1px solid #C4A484;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .service-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }
        .service-card h2 {
            color: #964B00;
        }
        .service-card .price {
            color: #333;
            font-weight: bold;
        }
        .service-card button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #964B00;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .service-card button:hover {
            background-color: #C4A484;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Our Services</h1>
        <form class="filters" method="GET" action="">
            <select name="service_type">
                <option value="">Select Service</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?= $service['service_id'] ?>" <?= $serviceType == $service['service_id'] ? 'selected' : '' ?>>
                        <?= $service['service_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="price_range">
                <option value="">Price Range</option>
                <option value="0-50" <?= $priceRange == '0-50' ? 'selected' : '' ?>>0 - 50</option>
                <option value="51-100" <?= $priceRange == '51-100' ? 'selected' : '' ?>>51 - 100</option>
            </select>
            <select name="sort_by">
                <option value="popularity" <?= $sortBy == 'popularity' ? 'selected' : '' ?>>Sort by Popularity</option>
                <option value="price" <?= $sortBy == 'price' ? 'selected' : '' ?>>Sort by Price</option>
            </select>
            <button type="submit">Filter</button>
        </form>
        <div class="service-cards">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="service-card">
                        <img src="../images/placeholder.jpg" alt="<?= $row['service_name'] ?>">
                        <h2><?= $row['service_name'] ?></h2>
                        <p><?= $row['description'] ?></p>
                        <p class="price">$<?= number_format($row['price'], 2) ?></p>
                        <button onclick="location.href='booking.php?service_id=<?= $row['service_id'] ?>'">Book Now</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No services found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
