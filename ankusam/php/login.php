<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("db.php");
    
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT email, password, name FROM registration_details WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];


            if (password_verify($password, $row['password'])) {
                $response = array('status' => 'success', 'name' => $name);
            } else {
                $response = array('status' => 'error', 'message' => 'Invalid password');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Invalid user');
        }
        $stmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Email or password not provided');
    }
    echo json_encode($response);
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Invalid request method'));
}
?>
