<?php
header('Content-Type: application/json');

include "connect.php";

if (isset($_GET['student_id'])) {
    $studentId = $_GET['student_id'];

    $sql = "SELECT first_name, middle_name, last_name, mobile_number, fees_paid FROM users WHERE student_id = ?";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        echo json_encode(array("success" => false, "message" => "Error preparing statement: " . $con->error));
        exit;
    }

    $stmt->bind_param("s", $studentId);
    $stmt->execute();
    $stmt->bind_result($firstName, $middleName, $lastName, $phoneNumber, $feesPaid);

    if ($stmt->fetch()) {
        // Assuming a predefined total amount
        $totalAmount = 50000.00; // Example total amount
        $remainingFees = $totalAmount - $feesPaid;

        echo json_encode(array(
            "success" => true,
            "first_name" => $firstName,
            "middle_name" => $middleName,
            "last_name" => $lastName,
            "phone_number" => $phoneNumber,
            "fees" => $remainingFees,
            "paid_fees" => $feesPaid,
            "total_amount" => $totalAmount
        ));
    } else {
        echo json_encode(array("success" => false, "message" => "No student found with the given ID."));
    }

    $stmt->close();
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request."));
}

$con->close();
?>
