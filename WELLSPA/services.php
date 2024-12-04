<?php
// Include the database connection
include 'setup.php';

// Initialize variables for filtering and sorting
$serviceType = isset($_GET['service_type']) ? $_GET['service_type'] : '';
$priceRange = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$duration = isset($_GET['duration']) ? $_GET['duration'] : '';
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'popularity';

// Build the SQL query based on filters and sorting
$sql = "SELECT * FROM services WHERE 1=1";

if ($serviceType) {
    $sql .= " AND service_type = '$serviceType'";
}

if ($priceRange) {
    $priceLimits = explode('-', $priceRange);
    $sql .= " AND price BETWEEN " . (float)$priceLimits[0] . " AND " . (float)$priceLimits[1];
}

if ($duration) {
    $sql .= " AND duration <= " . (int)$duration;
}

// Sorting
switch ($sortBy) {
    case 'price':
        $sql .= " ORDER BY price ASC";
        break;
    case 'duration':
        $sql .= " ORDER BY duration ASC";
        break;
    case 'popularity':
    default:
        $sql .= " ORDER BY service_id DESC"; // Assuming higher IDs are more popular
        break;
}

// Execute the query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 15px;
        }

        .filters form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filters select, .filters input, .filters button {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .filters button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .filters button:hover {
            background-color: #0056b3;
        }

        .service-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .service-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 280px;
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .service-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .service-card h2 {
            font-size: 1.5em;
            margin: 10px 0;
            color: #333;
        }

        .service-card p {
            color: #777;
            font-size: 0.9em;
        }

        .service-card .price {
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.1em;
        }

        .book-now {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .book-now:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Available Services</h1>

        <!-- Filters -->
        <div class="filters">
            <form method="GET" action="">
                <select name="service_type">
                    <option value="">Select Service Type</option>
                    <option value="type1">Type 1</option>
                    <option value="type2">Type 2</option>
                    <!-- Add more service types as needed -->
                </select>

                <select name="price_range">
                    <option value="">Select Price Range</option>
                    <option value="0-50">0 - 50</option>
                    <option value="51-100">51 - 100</option>
                    <!-- Add more price ranges as needed -->
                </select>

                <input type="number" name="duration" placeholder="Max Duration (min)" />

                <select name="sort_by">
                    <option value="popularity">Sort by Popularity</option>
                    <option value="price">Sort by Price</option>
                    <option value="duration">Sort by Duration</option>
                </select>

                <button type="submit">Filter</button>
            </form>
        </div>

                <p>No services found.</p>
        
        </div>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
