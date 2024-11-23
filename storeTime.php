<?php
// Database connection (adjust with your own credentials)
$host = 'localhost';
$dbname = 'brandedge';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Get JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Prepare SQL query to insert data
$sql = "INSERT INTO user_cookie_data (user_id, session_id, time_spent, timestamp, user_agent, referrer, functional_cookie, analytical_cookie, marketing_cookie)
        VALUES (:user_id, :session_id, :time_spent, :timestamp, :user_agent, :referrer, :functional_cookie, :analytical_cookie, :marketing_cookie)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Execute the statement with the provided data
$stmt->execute([
    'user_id' => $data['userId'],
    'session_id' => $data['sessionId'],
    'time_spent' => $data['timeSpent'],
    'timestamp' => $data['timestamp'],
    'user_agent' => $data['userAgent'],
    'referrer' => $data['referrer'],
    'functional_cookie' => $data['acceptedCookies']['functional'],
    'analytical_cookie' => $data['acceptedCookies']['analytical'],
    'marketing_cookie' => $data['acceptedCookies']['marketing']
]);

// Return success response
echo json_encode(['status' => 'success']);
?>
