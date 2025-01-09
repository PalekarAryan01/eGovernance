<?php
header('Content-Type: application/json');

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];
    $fees = $_POST['fees'];

    if (empty($studentId) || empty($fees)) {
        echo json_encode(array("success" => false, "message" => "Student ID and Fees are required."));
        exit;
    }

    $sql = "UPDATE users SET fees_paid = ? WHERE student_id = ?";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("success" => false, "message" => "Error preparing statement: " . $con->error));
        exit;
    }

    $stmt->bind_param("ds", $fees, $studentId);

    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "studentId" => $studentId, "fees" => $fees));
    } else {
        echo json_encode(array("success" => false, "message" => "Error updating record: " . $stmt->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
}
$con->close();
?>
