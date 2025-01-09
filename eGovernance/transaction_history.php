<?php
header('Content-Type: application/json');
include "connect.php";
$studentId = $_GET['student_id'];
$sql = "SELECT t.transaction_id, t.amount, t.transaction_type, t.transaction_date
        FROM transactions t
        INNER JOIN wallet w ON t.wallet_id = w.wallet_id
        WHERE w.student_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

$response = ["success" => true, "transactions" => $transactions];
echo json_encode($response);

$stmt->close();
$con->close();
?>
