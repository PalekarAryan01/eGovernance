<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_POST['content'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        include "connect.php";

        // Insert the notice into the database
        $sql = "INSERT INTO notices (title, content) VALUES ('$title', '$content')";

        if ($con->query($sql) === TRUE) {
            echo "Notice uploaded successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }

        // Close the connection
        $con->close();
    } else {
        echo "Title and content are required.";
    }
} else {
    echo "Invalid request method.";
}
?>
