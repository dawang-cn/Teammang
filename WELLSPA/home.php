<?php
include 'setup.php';
$services_sql = "SELECT service_name, description, price FROM services LIMIT 4";
$services_result = $conn->query($services_sql);

// Fetch reviews
$reviews_sql = "SELECT u.full_name, r.rating, r.comment 
                FROM reviews r 
                JOIN users u ON r.user_id = u.user_id 
                ORDER BY r.created_at DESC LIMIT 3";
$reviews_result = $conn->query($reviews_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Spa Wellness</title>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <h1>Your Wellness Journey Starts Here</h1>
        <p>Relax, Rejuvenate, and Recharge at Spa Wellness</p>
        <button onclick="location.href='booking.php'">Book Now</button>
        <button onclick="location.href='services.php'">View Services</button>
    </div>

    <h2>Popular Services</h2>
<div class="services-carousel">
    <div class="carousel-container">
        <!-- Massage Therapy -->
        <div class="service-card">
            <img src="images/massage.jpg" alt="Massage Therapy">
            <h3>Massage Therapy</h3>
            <p>Swedish, deep tissue, hot stone, aromatherapy, or Thai massage.</p>
            <button onclick="location.href='booking.php?service=massage'">Book Now</button>
        </div>
        
        <!-- Facial Treatments -->
        <div class="service-card">
            <img src="images/facial.jpg" alt="Facial Treatments">
            <h3>Facial Treatments</h3>
            <p>Cleansing, exfoliation, anti-aging, hydrating, or acne treatment facials.</p>
            <button onclick="location.href='booking.php?service=facial'">Book Now</button>
        </div>
        
        <!-- Body Treatments -->
        <div class="service-card">
            <img src="images/body_treatment.jpg" alt="Body Treatments">
            <h3>Body Treatments</h3>
            <p>Body scrubs, wraps, and detoxifying treatments.</p>
            <button onclick="location.href='booking.php?service=body_treatment'">Book Now</button>
        </div>
        
        <!-- Manicure & Pedicure -->
        <div class="service-card">
            <img src="images/manicure_pedicure.jpg" alt="Manicure & Pedicure">
            <h3>Manicure & Pedicure</h3>
            <p>Nail care, exfoliation, massage, and polish.</p>
            <button onclick="location.href='booking.php?service=manicure_pedicure'">Book Now</button>
        </div>
        
        <!-- Hydrotherapy -->
        <div class="service-card">
            <img src="images/hydrotherapy.jpg" alt="Hydrotherapy">
            <h3>Hydrotherapy</h3>
            <p>Steam baths, saunas, whirlpools, or Vichy showers.</p>
            <button onclick="location.href='booking.php?service=hydrotherapy'">Book Now</button>
        </div>
    </div>
    <button class="carousel-btn prev" onclick="moveCarousel(-1)">&#10094;</button>
    <button class="carousel-btn next" onclick="moveCarousel(1)">&#10095;</button>
</div>

<style>
    .services-carousel {
        position: relative;
        overflow: hidden;
        margin: 20px auto;
        width: 100%;
    }
    .carousel-container {
        display: flex;
        transition: transform 0.5s ease;
    }
    .service-card {
        min-width: 250px;
        max-width: 300px;
        margin: 10px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #fff;
    }
    .service-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 50%;
    }
    .prev {
        left: 10px;
    }
    .next {
        right: 10px;
    }
    .carousel-btn:hover {
        background-color: rgba(0,0,0,0.8);
    }
</style>

<script>
    let currentIndex = 0;
    function moveCarousel(direction) {
        const carousel = document.querySelector('.carousel-container');
        const cards = document.querySelectorAll('.service-card');
        const cardWidth = cards[0].offsetWidth + 20; // Card width + margin
        const totalWidth = cardWidth * cards.length;

        currentIndex += direction;
        if (currentIndex < 0) currentIndex = cards.length - 1;
        if (currentIndex >= cards.length) currentIndex = 0;

        carousel.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    }
</script>

    <!-- Testimonials Section -->
    <h2>Customer Testimonials</h2>
<div class="testimonials-slider">
    <div class="slider-container">
        <!-- Review 1 -->
        <div class="review-card">
            <img src="images/customer1.jpg" alt="Customer Photo">
            <p><strong>John Doe</strong> - Rating: ⭐⭐⭐⭐⭐</p>
            <p>"Fantastic service! I felt completely rejuvenated after my session."</p>
        </div>
        
        <!-- Review 2 -->
        <div class="review-card">
            <img src="images/customer2.jpg" alt="Customer Photo">
            <p><strong>Jane Smith</strong> - Rating: ⭐⭐⭐⭐</p>
            <p>"The ambiance is amazing, and the staff are very professional."</p>
        </div>
        
        <!-- Review 3 -->
        <div class="review-card">
            <img src="images/customer3.jpg" alt="Customer Photo">
            <p><strong>Emily Brown</strong> - Rating: ⭐⭐⭐⭐⭐</p>
            <p>"Best spa experience ever! I will definitely come back."</p>
        </div>
    </div>
    <button class="slider-btn prev" onclick="moveSlider(-1)">&#10094;</button>
    <button class="slider-btn next" onclick="moveSlider(1)">&#10095;</button>
</div>

<style>
    .testimonials-slider {
        position: relative;
        margin: 20px auto;
        overflow: hidden;
        width: 100%;
        max-width: 800px;
    }
    .slider-container {
        display: flex;
        transition: transform 0.5s ease;
    }
    .review-card {
        min-width: 250px;
        max-width: 300px;
        margin: 10px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;
    }
    .review-card img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }
    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        border-radius: 50%;
    }
    .prev {
        left: 10px;
    }
    .next {
        right: 10px;
    }
    .slider-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
</style>

<script>
    let reviewIndex = 0;
    function moveSlider(direction) {
        const slider = document.querySelector('.slider-container');
        const reviews = document.querySelectorAll('.review-card');
        const reviewWidth = reviews[0].offsetWidth + 20; // Card width + margin
        const totalWidth = reviewWidth * reviews.length;

        reviewIndex += direction;
        if (reviewIndex < 0) reviewIndex = reviews.length - 1;
        if (reviewIndex >= reviews.length) reviewIndex = 0;

        slider.style.transform = `translateX(-${reviewIndex * reviewWidth}px)`;
    }
</script>

    <!-- Call to Action -->
    <div class="call-to-action">
        <h2>Ready to Relax?</h2>
        <p>Create an account today or schedule your first session with us!</p>
        <button onclick="location.href='register.php'">Sign Up</button>
        <button onclick="location.href='booking.php'">Schedule Now</button>
    </div>
</body>
</html>

<?php
$conn->close();
?>
