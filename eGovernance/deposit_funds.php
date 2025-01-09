<?php
session_start();
include "connect.php";

if (isset($_SESSION['user_id'])) {
    $studentId = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    // Check if the amount is valid
    if ($amount > 0) {
        // Fetch the wallet_id for the logged-in student
        $sql = "SELECT wallet_id FROM wallet WHERE student_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $stmt->bind_result($walletId);
        $stmt->fetch();
        $stmt->close();

        // Update the wallet balance
        $sql = "UPDATE wallet SET balance = balance + ? WHERE wallet_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("di", $amount, $walletId);
        if ($stmt->execute()) {
            // Insert the transaction record
            $transaction_type = 'deposit';
            $sql = "INSERT INTO transactions (wallet_id, amount, transaction_type) VALUES (?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ids", $walletId, $amount, $transaction_type);
            $stmt->execute();

            $_SESSION['alert_message'] = "Deposit successful!";
            $_SESSION['alert_type'] = "alert-success";
        } else {
            $_SESSION['alert_message'] = "Failed to deposit money. Please try again.";
            $_SESSION['alert_type'] = "alert-error";
        }
        $stmt->close();
    } else {
        $_SESSION['alert_message'] = "Invalid deposit amount.";
        $_SESSION['alert_type'] = "alert-error";
    }
    $con->close();
} else {
    $_SESSION['alert_message'] = "Student not logged in.";
    $_SESSION['alert_type'] = "alert-error";
}

// Redirect to wallet page
header("Location: wallet.php");
exit;
?>
