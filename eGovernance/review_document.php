<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    // Redirect to login page if not authenticated
    header("Location: login.php");
    exit;
}

include 'connect.php'; // Include your database connection file

// Fetch users who have uploaded their Aadhaar card
$sql = "SELECT * FROM users WHERE aadhaar_path IS NOT NULL AND aadhaar_path != ''";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Document Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #467cd3;
            color: white;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .button {
            padding: 8px 16px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }
        .approve {
            background-color: #28a745;
        }
        .reject {
            background-color: #dc3545;
        }
        .action-buttons {
            display: flex;
            justify-content: flex-start;
        }
    </style>
</head>
<body>
    <h2>Document Approval</h2>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Class 10th Marksheet</th>
                <th>Class 12th Marksheet</th>
                <th>Aadhaar Card</th>
                <th>Caste Certificate</th>
                <th>Income Certificate</th>
                <th>Entrance Exams Marksheet</th>
                <th>Passport Size Photo</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo empty($row['class10_path']) ? 'N/A' : '<a href="' . $row['class10_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['class12_path']) ? 'N/A' : '<a href="' . $row['class12_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['aadhaar_path']) ? 'N/A' : '<a href="' . $row['aadhaar_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['caste_certificate_path']) ? 'N/A' : '<a href="' . $row['caste_certificate_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['income_certificate_path']) ? 'N/A' : '<a href="' . $row['income_certificate_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['entrance_marksheet_path']) ? 'N/A' : '<a href="' . $row['entrance_marksheet_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo empty($row['passport_photo_path']) ? 'N/A' : '<a href="' . $row['passport_photo_path'] . '" target="_blank">View</a>'; ?></td>
                <td><?php echo $row['document_status']; ?></td>
                <td>
                    <div class="action-buttons">
                        <form action="approve_reject.php" method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                            <button type="submit" name="action" value="approve" class="button approve">Approve</button>
                        </form>
                        <form action="approve_reject.php" method="post" style="display:inline;">
                            <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
                            <button type="submit" name="action" value="reject" class="button reject">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
