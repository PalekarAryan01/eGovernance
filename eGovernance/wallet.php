<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Wallet</title>
    <style> body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; } .container { background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 600px; } h1, h2 { text-align: center; color: #333; } .student-info { text-align: center; margin-bottom: 20px; font-size: 1.2em; color: #333; } .balance { text-align: center; margin-bottom: 20px; font-size: 1.5em; color: #007bff; } .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; color: white; } .alert-success { background-color: #4caf50; } .alert-error { background-color: #f44336; } table { width: 100%; border-collapse: collapse; margin-top: 20px; } table, th, td { border: 1px solid #ddd; } th { background-color: #004080; color: #fff; padding: 10px; } td { padding: 10px; text-align: left; } tr:nth-child(even) { background-color: #f2f2f2; } tr:hover { background-color: #ddd; } .deposit-button { display: flex; justify-content: center; margin-top: 20px; } .deposit-button button { padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease; } .deposit-button button:hover { background-color: #0056b3; } /* Modal styles */ .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4); justify-content: center; align-items: center; } .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 10px; text-align: center; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); animation: modalFadeIn 0.5s ease; } .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; } .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; } @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } } .form-group { margin-bottom: 20px; } .form-group label { display: block; margin-bottom: 5px; } .form-group input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; } .form-group button { width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px; transition: background-color 0.3s ease; } .form-group button:hover { background-color: #0056b3; } </style>
</head>
<body>
    <div class="container">
        <h1>Student Wallet</h1>

        <?php
            session_start();
            include "connect.php";

            // Display alert message if set
            if (isset($_SESSION['alert_message'])) {
                echo "<div class='alert " . $_SESSION['alert_type'] . "'>" . $_SESSION['alert_message'] . "</div>";
                unset($_SESSION['alert_message']);
                unset($_SESSION['alert_type']);
            }

            // Fetch Student Information
            if (isset($_SESSION['user_id'])) {
                $studentId = $_SESSION['user_id'];

                $sql = "SELECT first_name, middle_name, last_name, mobile_number FROM users WHERE student_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $studentId);
                $stmt->execute();
                $stmt->bind_result($firstName, $middleName, $lastName, $mobileNumber);
                $stmt->fetch();
                $stmt->close();
            } else {
                echo "<div class='alert alert-error'>Student not logged in.</div>";
                exit;
            }
        ?>

        <div class="student-info">
            <p>Name: <b><?php echo "$firstName $middleName $lastName"; ?></b></p>
            <p>Mobile Number: <b><?php echo $mobileNumber; ?></b></p>
        </div>

        <?php
            // Fetch Wallet Balance
            if (isset($studentId)) {
                $sql = "SELECT balance FROM wallet WHERE student_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $studentId);
                $stmt->execute();
                $stmt->bind_result($balance);
                $stmt->fetch();
                $stmt->close();
            }

            // Fetch Transaction History
            $transactions = [];
            if (isset($studentId)) {
                $sql = "SELECT t.transaction_id, t.amount, t.transaction_type, t.transaction_date
                        FROM transactions t
                        INNER JOIN wallet w ON t.wallet_id = w.wallet_id
                        WHERE w.student_id = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $studentId);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $transactions[] = $row;
                }
                $stmt->close();
            }
            $con->close();
        ?>

        <div class="balance">
            <p>Available Amount: <b>₹<span id="walletBalance"><?php echo $balance; ?></span></b></p>
        </div>

        <div class="deposit-button">
            <button onclick="document.getElementById('depositForm').style.display='block'">Deposit Money</button>
        </div>

        <div id="depositForm" style="display:none; margin-top:20px;">
            <form action="deposit_funds.php" method="post">
                <div class="form-group">
                    <label for="amount">Deposit Amount (₹):</label>
                    <input type="number" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <button type="submit">Deposit</button>
                </div>
            </form>
        </div>

        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="transactionHistory">
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo $transaction['transaction_id']; ?></td>
                        <td>₹<?php echo number_format($transaction['amount'], 2); ?></td>
                        <td><?php echo ucfirst($transaction['transaction_type']); ?></td>
                        <td><?php echo $transaction['transaction_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
