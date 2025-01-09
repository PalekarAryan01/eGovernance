<?php
include "connect.php";

// Fetch the notices from the database
$sql = "SELECT * FROM notices ORDER BY created_at DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Notices</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #000080;
        }
        .navbar {
            background-color: #4169e1;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: #ffffff;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #000080;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            padding: 20px;
        }
        header {
            background: #000080;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        h1 {
            font-size: 1.8em;
            margin: 0;
        }
        .card {
            background: #f2f2f2;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin: 0;
            font-size: 1.5em;
            color: #4169e1;
        }
        .card p {
            margin: 10px 0;
        }
        footer {
            background-color: #4169e1;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>
    <!-- <div class="navbar">
        <a href="#">Home</a>
        <a href="#">Notices</a>
        <a href="#">Contact</a>
    </div> -->
    <div class="container">
        <header>
            <h1>Notices</h1>
        </header>
        <?php
        if ($result->num_rows > 0) {
            $sr_no = 1; // Initialize serial number
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h2>" . $sr_no++ . ". " . $row["title"] . "</h2>";
                echo "<p>" . $row["content"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='card'><p>No notices found.</p></div>";
        }
        $con->close();
        ?>
    </div>
    <!-- <footer>
        &copy; 2025 Your Institution Name. All rights reserved.
    </footer> -->
</body>
</html>
