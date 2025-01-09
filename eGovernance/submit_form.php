<?php
session_start(); // Start the session

// Ensure the user is logged in and user ID is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; // Get the user ID from the session

include 'connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = $_POST['name'];
    $last_name = $_POST['surname'];
    $mother_name = $_POST['mother_name'];
    $father_name = $_POST['father_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $blood_group = $_POST['blood_group'];
    $caste = $_POST['caste'];
    $mother_tongue = $_POST['mother_tongue'];
    $father_occupation = $_POST['father_occupation'];
    $mother_occupation = $_POST['mother_occupation'];
    $secondary_school = $_POST['secondary'];
    $marks10 = $_POST['marks10'];
    $high_secondary_school = $_POST['high_secondary'];
    $marks12 = $_POST['marks12'];
    $preferred_course = $_POST['course'];
    // $address = $_POST['address'];

    // Directory for uploading documents
    $target_dir = "uploads/";

    // Paths for uploaded files
    $class10_path = $target_dir . basename($_FILES["class10"]["name"]);
    $class12_path = $target_dir . basename($_FILES["class12"]["name"]);
    $aadhaar_path = $target_dir . basename($_FILES["aadhaar"]["name"]);
    $caste_certificate_path = $target_dir . basename($_FILES["caste_certificate"]["name"]);
    $income_certificate_path = $target_dir . basename($_FILES["income_certificate"]["name"]);
    $entrance_marksheet_path = $target_dir . basename($_FILES["entrance_marksheet"]["name"]);
    $passport_photo_path = $target_dir . basename($_FILES["passport_photo"]["name"]);

    // Move uploaded files to target directory
    move_uploaded_file($_FILES["class10"]["tmp_name"], $class10_path);
    move_uploaded_file($_FILES["class12"]["tmp_name"], $class12_path);
    move_uploaded_file($_FILES["aadhaar"]["tmp_name"], $aadhaar_path);
    move_uploaded_file($_FILES["caste_certificate"]["tmp_name"], $caste_certificate_path);
    move_uploaded_file($_FILES["income_certificate"]["tmp_name"], $income_certificate_path);
    move_uploaded_file($_FILES["entrance_marksheet"]["tmp_name"], $entrance_marksheet_path);
    move_uploaded_file($_FILES["passport_photo"]["tmp_name"], $passport_photo_path);

    // Insert data into users table
    $sql = "UPDATE users SET 
            first_name='$first_name', 
            middle_name='$mother_name', 
            last_name='$last_name', 
            mobile_number='$phone', 
            email='$email',
            class10_path='$class10_path',
            class12_path='$class12_path',
            aadhaar_path='$aadhaar_path',
            caste_certificate_path='$caste_certificate_path',
            income_certificate_path='$income_certificate_path',
            entrance_marksheet_path='$entrance_marksheet_path',
            passport_photo_path='$passport_photo_path'
            WHERE student_id='$user_id'";

    if ($con->query($sql) === TRUE) {
        echo "Record updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>
