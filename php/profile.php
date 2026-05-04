<?php
require '../vendor/autoload.php';

$redis = new Predis\Client();
$mongo = (new MongoDB\Client("mongodb://localhost:27017"))->guvi_db->profiles;

$token = $_REQUEST['token'] ?? '';
$userId = $redis->get($token);

if (!$userId) {
    echo json_encode(["error" => "No Session Found"]);
    exit;
}

// Agar GET request hai toh data dikhao
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = $mongo->findOne(['user_id' => (int)$userId]);
    echo json_encode($data);
} 
// Agar POST request hai toh data update karo
else {
    $mongo->updateOne(
        ['user_id' => (int)$userId], 
        ['$set' => [
            'age' => $_POST['age'], 
            'dob' => $_POST['dob'], 
            'contact' => $_POST['contact']
        ]]
    );
    echo json_encode(["status" => "success"]);
}
?>