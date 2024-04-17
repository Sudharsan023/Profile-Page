<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = require_once("db.php");
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob =$_POST['dob'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $checkUserStmt = $conn->prepare("SELECT email FROM registration_details WHERE email = ?");
    $checkUserStmt->bind_param("s", $email);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();

    if ($checkUserStmt->num_rows > 0) {
        $response = array("status" => "error", "message" => "❌ Email already registered");
        echo json_encode($response);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO registration_details (name ,email,dob,mobile, password) VALUES (?, ?, ?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $dob,$mobile, $hashed_password);

        if ($stmt->execute()) {
            $response = array('status' => 'success');
            echo json_encode($response);
        } else {
            $response = array('status' => 'error');
            echo json_encode($response);
        }
        $stmt->close();
    }
    $checkUserStmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
