<?php
include 'headfooter/header3.php'; // Include the header
?>

<style>
    /* General Page Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f6f7;
    }

    /* Container for the main content */
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 40px;
        text-align: center;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 100px; /* Increased top margin to avoid overlap with the navigation */
        max-width: 900px; /* Limit max width for better responsiveness */
    }

    /* Heading Styles */
    h1 {
        font-size: 2.5em;
        color: #e74c3c;
        margin-bottom: 20px;
    }

    /* Paragraph Styles */
    p {
        font-size: 1.2em;
        color: #34495e;
        margin-bottom: 20px;
    }

    /* Encouragement message style */
    .encouragement {
        font-size: 1.5em;
        margin-top: 30px;
        color: #27ae60;
        font-weight: bold;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            width: 95%;
            padding: 20px;
        }

        h1 {
            font-size: 2em;
        }

        .encouragement {
            font-size: 1.3em;
        }
    }
</style>

<div class="container">
    <h1>此頁面正在更新中!</h1>
    <p>感謝您蒞臨本網站。</p>

    <!-- Encouragement message -->
    <div class="encouragement">
        <p>一切都在進行中！我們正在努力為您提供更好的內容，敬請期待！💪</p>
        <p>別擔心，精彩的東西馬上就會來到！</p>
    </div>
</div>

<?php
include 'include/footer.php'; // Include the footer
?>

