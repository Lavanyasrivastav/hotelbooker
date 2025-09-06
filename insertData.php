<?php
header('Content-Type: application/json');
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$crop = $data['crop'];
$soil = $data['soil'];
$advice = $data['advice'];

$sql = "INSERT INTO advisory (crop, soil, advice) VALUES ('$crop', '$soil', '$advice')";

if ($conn->query($sql)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}
?>
