<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "localhost"; // Your XAMPP server
$dbname = "brandedge"; // Your database name
$username = "root"; // Your XAMPP username
$password = ""; // Your XAMPP password

$conn = new mysqli($host, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert form data into the database
    $sql = "INSERT INTO brandedgedata (fullname, email, phone,subject,message, Date, Time) VALUES ('$fullname', '$email', '$phone', '$subject', '$message', NOW(), NOW())";
  
    if ($conn->query($sql) == TRUE) {
        header("Location: /BRANDEDGE/success.html");
        exit();
    }
     else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
