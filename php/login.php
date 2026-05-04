<?php
require '../vendor/autoload.php';

$mysql = new mysqli("localhost", "root", "", "guvi_db");

// Redis Connection
$redis = new Predis\Client();

$user = $_POST['username'];
$pass = $_POST['password'];

$stmt = $mysql->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res && password_verify($pass, $res['password'])) {
    // Unique Token generate karna
    $token = bin2hex(random_bytes(16));
    
    // Redis mein token store karna (1 ghante ke liye)
    $redis->setex($token, 3600, $res['id']);
    
    echo json_encode(["status" => "success", "token" => $token]);
} else {
    echo json_encode(["status" => "error"]);
}
?>