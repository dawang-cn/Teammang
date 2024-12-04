<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'booking_system';

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === FALSE) {
    echo "Database creation failed." . $conn->error . "<br>";
}

$conn->select_db($db_name);

$sql = "
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'therapist', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    echo "Users table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    duration INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === FALSE) {
    echo "Services table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    therapist_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'canceled') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (therapist_id) REFERENCES Users(user_id),
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
)";
if ($conn->query($sql) === FALSE) {
    echo "Appointments table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('cash', 'credit_card', 'paypal') NOT NULL,
    payment_status ENUM('paid', 'unpaid', 'refunded') NOT NULL,
    transaction_id VARCHAR(100) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES Appointments(appointment_id)
)";
if ($conn->query($sql) === FALSE) {
    echo "Payments table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS availability (
    availability_id INT AUTO_INCREMENT PRIMARY KEY,
    therapist_id INT NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (therapist_id) REFERENCES Users(user_id)
)";
if ($conn->query($sql) === FALSE) {
    echo "Availability table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES Appointments(appointment_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
)";
if ($conn->query($sql) === FALSE) {
    echo "Reviews table creation failed." . $conn->error . "<br>";
}

$sql = "
CREATE TABLE IF NOT EXISTS promotions (
    promo_id INT AUTO_INCREMENT PRIMARY KEY,
    promo_code VARCHAR(50) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    discount_percent DECIMAL(5, 2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL
)";
if ($conn->query($sql) === FALSE) {
    echo "Promotions table creation failed." . $conn->error . "<br>";
}
?>