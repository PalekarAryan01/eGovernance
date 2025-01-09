<?php
session_start(); // Start the session

// Ensure the user is logged in and user ID is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

include "connect.php";

// Fetch user data
$sql = "SELECT * FROM users WHERE student_id = $user_id";
$result = $con->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Set default values if no data found
    $row = [
        'first_name' => '',
        'last_name' => '',
        'mobile_number' => '',
        'email' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e3f2fd; /* Very light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #ffffff; /* White background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0,0,1,0.9);
            width: 80%;
            max-width: 800px;
            border: 2px solid #3f51b5; /* Royal blue border */
            color: #212121; /* Dark text color */
        }
        h2 {
            text-align: center;
            color: #3f51b5; /* Royal blue color */
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            color: #3f51b5; /* Royal blue color */
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #3f51b5; /* Royal blue border */
            border-radius: 5px;
            font-size: 1em;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .form-group input[type="checkbox"] {
            width: auto;
        }
        .form-group a {
            color: #3f51b5; /* Royal blue color */
        }
        .form-group a:hover {
            text-decoration: underline;
        }
        fieldset {
            border: 1px solid #3f51b5; /* Royal blue border */
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 15px;
        }
        legend {
            font-size: 1.2em;
            color: #3f51b5; /* Royal blue color */
            margin-bottom: 10px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #3f51b5; /* Royal blue color */
            color: #ffffff; /* White text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
        }
        button[type="submit"]:hover {
            background-color: #303f9f; /* Darker royal blue color */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admission Form</h2>
        <form action="submit_form.php" method="post" enctype="multipart/form-data">
            <!-- Name Details -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo $row['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname" value="<?php echo $row['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mother-name">Mother's Name</label>
                <input type="text" id="mother-name" name="mother_name" placeholder="Enter your mother's name" required>
            </div>
            <div class="form-group">
                <label for="father-name">Father's Name</label>
                <input type="text" id="father-name" name="father_name" placeholder="Enter your father's name" required>
            </div>

            <!-- Contact Information -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" value="<?php echo $row['mobile_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo $row['email']; ?>" required>
            </div>

            <!-- Additional Information -->
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="100" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="blood-group">Blood Group</label>
                <input type="text" id="blood-group" name="blood_group" placeholder="Enter your blood group" required>
            </div>
            <div class="form-group">
                <label for="caste">Caste</label>
                <input type="text" id="caste" name="caste" placeholder="Enter your caste" required>
            </div>
            <div class="form-group">
                <label for="mother-tongue">Mother Tongue</label>
                <input type="text" id="mother-tongue" name="mother_tongue" placeholder="Enter your mother tongue" required>
            </div>

            <!-- Parent Occupation -->
            <fieldset>
                <legend>Father's Occupation</legend>
                <div class="form-group">
                    <label for="father-occupation"></label>
                    <input type="text" id="father-occupation" name="father_occupation" placeholder="Enter your father's occupation" required>
                </div>
            </fieldset>
            <fieldset>
                <legend>Mother's Occupation</legend>
                <div class="form-group">
                    <label for="mother-occupation"></label>
                    <input type="text" id="mother-occupation" name="mother_occupation" placeholder="Enter your mother's occupation" required>
                </div>
            </fieldset>

            <!-- Educational Qualifications -->
            <fieldset>
                <legend>Educational Details</legend>
                <div class="form-group">
                    <label for="secondary">Secondary (10th Grade)</label>
                    <input type="text" id="secondary" name="secondary" placeholder="Enter your school name" required>
                </div>
                <div class="form-group">
                    <label for="marks10">Percentage/Grade Obtained</label>
                    <input type="text" id="marks10" name="marks10" placeholder="Enter your marks or grade" required>
                </div>
                <div class="form-group">
                    <label for="high-school">Higher Secondary (12th Grade)</label>
                    <input type="text" id="high-secondary" name="high_secondary" placeholder="Enter your college name" required>
                </div>
                <div class="form-group">
                    <label for="marks12">Percentage/Grade Obtained</label>
                    <input type="text" id="marks12" name="marks12" placeholder="Enter your marks or grade" required>
                </div>
            </fieldset>

            <!-- Course Preferences -->
            <div class="form-group">
                <label for="course">Preferred Course</label>
                <select id="course" name="course" required>
                    <option value="">Select a course</option>
                    <option value="bachelor_of_science">Bachelor of Science</option>
                    <option value="bachelor_of_arts">Bachelor of Arts</option>
                    <option value="bachelor_of_engineering">Bachelor of Engineering</option>
                    <option value="bachelor_of_commerce">Bachelor of Commerce</option>
                </select>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" placeholder="Enter your address" required></textarea>
            </div>

            <!-- Document Upload -->
            <fieldset>
                <legend>Document Upload</legend>
                <div class="form-group">
                    <label for="class10">Class 10th Marksheet</label>
                    <input type="file" id="class10" name="class10" required>
                </div>
                <div class="form-group">
                    <label for="class12">Class 12th Marksheet</label>
                    <input type="file" id="class12" name="class12" required>
                </div>
                <div class="form-group">
                    <label for="aadhaar">Aadhaar Card (as identity proof)</label>
                    <input type="file" id="aadhaar" name="aadhaar" required>
                </div>
                <div class="form-group">
                    <label for="caste_certificate">Caste Certificate (for students applying under reserved categories)</label>
                    <input type="file" id="caste_certificate" name="caste_certificate" required>
                </div>
                <div class="form-group">
                    <label for="income_certificate">Income Certificate (for scholarships)</label>
                    <input type="file" id="income_certificate" name="income_certificate" required>
                </div>
                <div class="form-group">
                    <label for="entrance_marksheet">Entrance Exams Marksheet</label>
                    <input type="file" id="entrance_marksheet" name="entrance_marksheet" required>
                </div>
                <div class="form-group">
                    <label for="passport_photo">Passport Size Photo</label>
                    <input type="file" id="passport_photo" name="passport_photo" required>
                </div>
            </fieldset>

            <div class="form-group">
                <label for="terms">
                    I agree to the <a href="terms-and-conditions.html" target="_blank">Terms and Conditions</a>.
                    <input type="checkbox" id="terms" name="terms" required>
                </label>
            </div>

            <!-- Submission -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

                    