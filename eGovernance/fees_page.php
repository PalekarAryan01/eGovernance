<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Fee Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd; /* Very light blue background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #ffffff; /* Light background color */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            height: auto; /* Adjust height */
            margin: 20px;
            border: 2px solid #90caf9; /* Light blue border */
            color: #212121; /* Dark text color for better contrast */
        }
        .college-name {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #0288d1; /* Blue color */
            margin-bottom: 10px;
        }
        h1, h2 {
            text-align: center;
            color: #0288d1; /* Blue color */
            margin-bottom: 20px;
        }
        .student-info, .summary {
            text-align: left;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #424242; /* Dark grey text color */
        }
        .student-info p, .summary p {
            margin: 5px 0;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: white;
        }
        .alert-error {
            background-color: #f44336;
        }
        .summary {
            background-color: #e1f5fe; /* Very light blue background color */
            padding: 20px;
            border: 1px solid #90caf9; /* Light blue border */
            border-radius: 10px;
        }
        .additional-content {
            background-color: #e1f5fe; /* Very light blue background color */
            padding: 20px;
            border: 1px solid #90caf9; /* Light blue border */
            border-radius: 10px;
            margin-top: 20px;
            font-size: 1.1em;
            color: #424242; /* Dark grey text color */
        }
        .print-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .print-button button {
            padding: 10px 20px;
            background-color: #0288d1; /* Blue color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button button:hover {
            background-color: #0277bd; /* Darker blue color */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="college-name">Thakur College</div>
        <h1>College Fee Receipt</h1>
        
        <?php
session_start();
include "connect.php";

if (isset($_SESSION['user_id'])) {
    $studentId = $_SESSION['user_id'];

    $sql = "SELECT first_name, middle_name, last_name, mobile_number, email, total_amount, fees_paid FROM users WHERE student_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $stmt->bind_result($firstName, $middleName, $lastName, $mobileNumber, $email, $total_fees, $paid_fees);
    $stmt->fetch();
    $stmt->close();
    $con->close();

    // Set default total fees to 50000 if not set
    if (!$total_fees || $total_fees == 0) {
        $total_fees = 50000.00;
    }

    $pending_fees = $total_fees - $paid_fees;
} else {
    echo "<div class='alert alert-error'>Student not logged in.</div>";
    exit;
}
?>


<div class="student-info">
    <p><strong>Name:</strong> <?php echo htmlspecialchars("$firstName $middleName $lastName"); ?></p>
    <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($mobileNumber); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
</div>


        <div class="summary">
            <p><strong>Total Fees:</strong> ₹<?php echo number_format($total_fees, 2); ?></p>
            <p><strong>Paid Fees:</strong> ₹<?php echo number_format($paid_fees, 2); ?></p>
            <p><strong>Pending Fees:</strong> ₹<?php echo number_format($pending_fees, 2); ?></p>
        </div>

        <div class="additional-content">
            <p><strong>Note:</strong> Please ensure that the pending fees are paid by the end of the month to avoid any late fees. For any queries, contact the administration office.</p>
            <p>Thank you for your cooperation!</p>
        </div>

        <div class="print-button">
            <button onclick="window.print()">Print Receipt</button>
        </div>
    </div>
</body>
</html>
