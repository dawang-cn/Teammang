<?php
include 'setup.php';

// Default query to fetch services without filters
$sql = "SELECT * FROM services WHERE 1=1";

// Handle service type filter
if (isset($_GET['service_type']) && $_GET['service_type'] != '') {
    $service_type = $_GET['service_type'];
    $sql .= " AND service_id = '$service_type'";
}

// Handle price range filter
if (isset($_GET['price_range']) && $_GET['price_range'] != '') {
    $price_range = $_GET['price_range'];
    $price_limits = explode('-', $price_range);
    $sql .= " AND price BETWEEN {$price_limits[0]} AND {$price_limits[1]}";
}

// Handle sorting options (price and duration)
if (isset($_GET['sort_by']) && $_GET['sort_by'] != '') {
    $sort_by = $_GET['sort_by'];
    if ($sort_by == 'price') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sort_by == 'duration') {
        $sql .= " ORDER BY duration ASC";
    }
}

// Fetch filtered services
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
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
        <!-- Filter form -->
        <form class="filters" method="GET" action="services.php">
            <label for="service_type">Select Service</label>
            <select name="service_type">
                <option value="">All Services</option>
                <option value="1">Massage Therapy</option>
                <option value="2">Facial Treatments</option>
                <option value="3">Body Treatments</option>
                <option value="4">Manicure & Pedicure</option>
            </select>

            <label for="price_range">Price Range</label>
            <select name="price_range">
                <option value="">All Prices</option>
                <option value="0-50">0 - 50</option>
                <option value="51-100">51 - 100</option>
                <option value="101-200">101 - 200</option>
            </select>

            <label for="sort_by">Sort By</label>
            <select name="sort_by">
                <option value="price">Price</option>
                <option value="duration">Duration</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <div class="service-cards">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="service-card">
                        <?php
                        // Determine the image based on the service
                        $service_image = "";
                        switch ($row['service_id']) {
                            case 1: // Massage Therapy
                                $service_image = 'massage.png';
                                break;
                            case 2: // Facial Treatments
                                $service_image = 'facial.jpg';
                                break;
                            case 3: // Body Treatments
                                $service_image = 'body_treatment.jpg';
                                break;
                            case 4: // Manicure & Pedicure
                                $service_image = 'manicure_pedicure.jpg';
                                break;
                            default:
                                $service_image = 'massage.png'; // Default image
                        }
                        ?>
                        <img src="../images/<?= $service_image; ?>" alt="<?= htmlspecialchars($row['service_name']); ?>">
                        <h2><?= htmlspecialchars($row['service_name']); ?></h2>
                        <p class="price">$<?= htmlspecialchars($row['price']); ?></p>
                        <p>Description: <?= htmlspecialchars($row['description']); ?></p>
                        <p>Duration: <?= htmlspecialchars($row['duration']); ?> mins</p>
                        <button onclick="window.location.href='booking.php?service_id=<?= $row['service_id']; ?>'">Book Now</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No services found based on your criteria.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
