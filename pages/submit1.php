
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Path to autoload file from Composer

$mail = new PHPMailer(true);

// Database connection
$host = 'localhost'; 
$dbname = 'brandedge'; // Your database name
$username = 'brandedge'; // Your XAMPP username (default is 'root')
$password = 'Blessediam@21'; // Your XAMPP password (default is empty)

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert form data into the database
    $sql = "INSERT INTO brandedgedata (fullname, email, phone, message, Date, Time) VALUES ('$fullname', '$email', '$phone', '$message', NOW(), NOW())";
  
    if ($conn->query($sql) === TRUE) {
        try {
            //Server settings
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';                      
            $mail->SMTPAuth = true;                              
            $mail->Username = 'snehaparikh8986@gmail.com';  // Your Gmail address
            $mail->Password = 'gpvo oxdz orgy nbot';           // Your Gmail App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS encryption
            $mail->Port = 587;                                   

            //Recipients
            $mail->setFrom('viraj.kothari2003@gmail.com', 'BRAND EDGE DIGITAL'); // Your email and company name
            $mail->addAddress($email);  // User's email from the form

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Form Submission Success';
            $mail->Body    = "Dear $fullname,<br><br>Thank you for getting in touch!<br>Here is a copy of your message:<br><br>"
                             . "Full Name: $fullname<br>Email: $email<br>Phone: $phone<br>Message: $message<br><br>"
                             . "We will get back to you shortly.<br><br>Best regards,<br>Brand Edge Digital Marketing";

            // Send the email
            $mail->send();

            // Redirect after successful email and database insertion
            echo "<script>alert('Message sent successfully!');</script>";
            header("Location: ../index.html");
            exit();
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
