<?php
include "connect.php";

// Initialize a message variable
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Validation
    if (empty($email) || empty($password) || empty($status)) {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        // Prepare SQL statement to check user credentials
        $sql = "SELECT * FROM users WHERE email = ? AND status = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $email, $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Start the session and set session variables
            session_start();
            $_SESSION['user_id'] = $user['student_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = $user['status'];

            // Redirect based on user status
            if ($user['status'] === 'admin') {
                header("Location: adminDash.php");
                exit;
            } else {
                header("Location: studDash.php");
                exit;
            }
        } else {
            $message = "Invalid login credentials or role.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Governance</title>
    <style>
        /* CSS styles for the login page */
        body {
            background: linear-gradient(to right, #e2e2e2, #c9dcff);
            font-family: Arial, sans-serif;
            color: rgb(9, 94, 192) ;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 400px;
            padding: 30px 25px;
        }
        #heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: bold;
            color:rgb(9, 94, 192) ;
        }
        .field {
            margin-bottom: 20px;
        }
        .field select,
        .field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .field select:focus,
        .field input:focus {
            border: 1px solid rgb(9, 94, 192) ;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 45, 98, 0.5);
        }
        .btn {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .button {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .button-primary {
            background-color:rgb(9, 94, 192) ;
            color: white;
        }
        .button-primary:hover {
            background-color: #001a44;
        }
        .button-secondary {
            background-color: white;
            color:rgb(9, 94, 192) ;
            border: 1px solid rgb(9, 94, 192) ;
        }
        .button-secondary:hover {
            background-color: rgb(9, 94, 192) ;
            color: white;
        }
        .button-forgot {
            width: 100%;
            background-color: #f0f0f0;
            color: #666;
            border: none;
            margin-top: 10px;
        }
        .button-forgot:hover {
            background-color: #e2e2e2;
            color: rgb(9, 94, 192) ;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var message = "<?php echo $message; ?>";
            if (message !== "") {
                alert(message);
            }

            document.getElementById("signup-button").addEventListener("click", function () {
                window.location.href = "register.php";
            });
        });
    </script>
</head>
<body>
    <div class="form">
        <p id="heading">Login</p>
        <form method="POST" action="">
            <div class="field">
                <select name="status" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="field">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="field">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="btn">
                <button type="submit" class="button button-primary">Login</button>
                <button type="button" id="signup-button" class="button button-secondary">Sign Up</button>
            </div>
            <button type="button" class="button button-forgot">Forgot Password</button>
        </form>
    </div>
</body>
</html>
