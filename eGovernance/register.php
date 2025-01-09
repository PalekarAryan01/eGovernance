<?php 
include "connect.php";

// Initialize a message variable
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $firstName = trim($_POST['first_name']);
    $middleName = trim($_POST['middle_name']);
    $lastName = trim($_POST['last_name']);
    $mobileNumber = trim($_POST['mobile_number']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($firstName) || empty($lastName) || empty($mobileNumber) || empty($email) || empty($password)) {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!preg_match('/^\d{10}$/', $mobileNumber)) {
        $message = "Mobile number must be 10 digits.";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $message = "Password must be at least 8 characters long and include uppercase, lowercase, and numeric characters.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO users (first_name, middle_name, last_name, mobile_number, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $middleName, $lastName, $mobileNumber, $email, $hashedPassword);

        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            // Create a wallet entry
            $sql = "INSERT INTO wallet (student_id, balance) VALUES (?, 0)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                $message = "Registration successful";
            } else {
                $message = "Error creating wallet: " . $stmt->error;
            }
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Governance - Register Page</title>
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #c9dcff);
            font-family: Arial, sans-serif;
            color: #rgb(9, 94, 192) ;
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
            transition: transform 0.4s ease-in-out;
        }
        .form:hover {
            transform: scale(1.05);
        }
        #heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
            font-weight: bold;
            color: rgb(9, 94, 192) ;
        }
        .field {
            margin-bottom: 20px;
        }
        .field input {
            width: 100%;
            padding: 10px;
            padding: left 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            color: rgb(9, 94, 192) ;
        }
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
            background-color: rgb(9, 94, 192) ;
            color: white;
        }
        .button-primary:hover {
            background-color: #001a44;
        }
        .button-secondary {
            background-color: white;
            color: rgb(9, 94, 192) ;
            border: 1px solid rgb(9, 94, 192) ;
        }
        .button-secondary:hover {
            background-color: rgb(9, 94, 192) ;
            color: white;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var message = "<?php echo $message; ?>";
            if (message !== "") {
                alert(message);
            }

            document.getElementById("login-button").addEventListener("click", function () {
                window.location.href = "login.php";
            });
        });
    </script>
</head>
<body>
    <div class="form">
        <p id="heading">Registration</p>
        <form method="POST" action="">
            <div class="field">
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="field">
                <input type="text" name="middle_name" placeholder="Middle Name">
            </div>
            <div class="field">
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="field">
                <input type="text" name="mobile_number" placeholder="Mobile Number" required>
            </div>
            <div class="field">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="field">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="btn">
                <button type="submit" class="button button-primary">Sign Up</button>
                <button type="button" id="login-button" class="button button-secondary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
