<?php
include 'setup.php';

// Fetch all services from the database
$sql = "SELECT * FROM services";
$services_result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Services</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .services-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .services-table th, .services-table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .services-table th {
            background-color: #964B00;
            color: #fff;
        }

        .services-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .services-table td {
            background-color: #fff;
        }
    </style>
</head>
<body>

<div class="services-table">
    <h2 style="text-align: center; color: #964B00;">Service List</h2>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($services_result->num_rows > 0) {
                // Iterate through each service row and display the details
                while ($row = $services_result->fetch_assoc()) {
                    
                    $service_name = isset($row['service_name']) ? $row['service_name'] : 'No Name Provided';
                    $description = isset($row['description']) ? $row['description'] : 'No Description';
                    $price = isset($row['price']) ? $row['price'] : 'N/A';
                    $duration = isset($row['duration']) ? $row['duration'] : 'Unknown Duration';

                    echo "<tr>
                            <td>{$service_name}</td>
                            <td>{$description}</td>
                            <td>{$price}</td>
                            <td>{$duration}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No services available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
