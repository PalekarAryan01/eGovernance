<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit;
}

include 'connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $document_status = 'approved';
    } elseif ($action == 'reject') {
        $document_status = 'rejected';
    }

    // Update document status in the database
    $sql = "UPDATE users SET document_status='$document_status' WHERE student_id='$student_id'";

    if ($con->query($sql) === TRUE) {
        echo "Document status updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Redirect back to the admin page
    header("Location: review_document.php");
    exit();
}
?>
